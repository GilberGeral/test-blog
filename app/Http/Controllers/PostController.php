<?php

namespace App\Http\Controllers;
use App\Models\Autor;
use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller{
  public function __construct() {
    parent::__construct();
    $this->long_mask=16;
  }

  public function crear(Request $request) {
    $data = $request->all();
           
    $validator = Validator::make($data, [
      'autor' => 'required|string|size:16',
      'titulo' => 'required|string|min:3',
      'content' => 'required|string|max:512',
      'imagen' => 'required|file|mimes:jpg,png,jpeg|max:2048'
    ]);
    
    if ($validator->fails()) {
      error_log('fail en validator'); 
      $this->response["code"] = 422;
      $this->response["msg"] = "Error de validación (0x0324)";
      $this->response["data"] = $validator->errors();
      return response()->json($this->response, 422);
    }
    
    
    $autor = Autor::where('IdMask', $data['autor'])->first();
    if ($autor == null) {
      $this->response["code"] = 409;
      $this->response["msg"] = "Autor no encontrado!";
      return response()->json($this->response, 409);
    }
    
    $this->response["code"] = 200;
    $now = Carbon::now($this->time_zone);
    $filename = '';
   
    if ($request->hasFile('imagen')) {
      
      $file = $request->file('imagen');
      $extension = $file->getClientOriginalExtension();
      $filename = $this->createCode(12);
      $filename .= ".";
      $filename .= $extension;      
      Storage::disk('local')->put($this->posts_folder . $filename, $file->get());//TODO: lod e que cada autor tenga su carpeta de posts
     
    }
    
    $post = new Post();    
    
    error_log('aaa');
    $post->IdMask = $this->createCode($this->long_mask);
    $post->IdAutor = $autor->IdAutor;
    $post->titulo = $data['titulo'];
    $post->contenido = $data['content'];
    $post->imagen = $filename;;
    $post->created_at = $now;
    $post->updated_at = $now;error_log('bbb');
    $post->created_by = "front";
    $post->updated_by = "front";    
   
    $post->save();
   
    $this->response["code"] = 200;
    $this->response["done"] = true;
    $this->response["data"] = [];
    $this->response["msg"] = "Post creado correctamente";    
    return response()->json($this->response, 200);

  }//fin de crear

  public function getList(Request $request){
    $data = $request->all();
    foreach ( $data as $k => $v ){
      error_log( "k: ".$k." v: ".$v );    
    }
    if( $data["autor"] == "todos" ){

      $_data = Post::select('IdMask AS Id', 'IdAutor', 'titulo', 'contenido','imagen', 'created_at')
      ->with(['autor' => function($query) {  
        $query->select('IdAutor', 'Nombre');
       }])
      ->orderByDesc('created_at')
      ->get();

      foreach ( $_data as $dt ){
        $post = [
          "Id" => $dt->Id,
          "titulo" => $dt->titulo,
          "contenido" => $dt->contenido,
          "autor" => $dt->autor->Nombre,
          "imagen" => $dt->imagen,
          "created_at" => $dt->created_at,
        ];
        array_push($this->response["data"],$post);
      }
      

    }else{
      //un solo autor
      $autor = Autor::where('IdMask', $data['autor'])->first();
      if ($autor == null) {
        
      } else {

        $_data = Post::select('IdMask AS Id', 'IdAutor', 'titulo', 'contenido', 'imagen', 'created_at')
        ->where('IdAutor', $autor->IdAutor)
        ->with(['autor' => function($query) {  
          $query->select('IdAutor', 'Nombre');
        }])
        ->orderByDesc('created_at')
        ->get();

        foreach ( $_data as $dt ){
          $post = [
            "Id" => $dt->Id,
            "titulo" => $dt->titulo,
            "contenido" => $dt->contenido,
            "autor" => $dt->autor->Nombre,
            "imagen" => $dt->imagen,
            "created_at" => $dt->created_at,
          ];
          array_push($this->response["data"],$post);
        }
      }
    }
    // dd($this->response["data"]);
    $this->response["code"] = 200;
    $this->response["done"] = true;
    return response()->json($this->response, 200);
  }
  
  public function actualizar(Request $request) {

    $data = $request->all();
    
    $validator = Validator::make($data, [
      'IdPost' => 'required|string|size:32',
      'titulo' => 'required|string|min:3',
      'content' => 'required|max:512',
      'imagen' => 'nullable|file|mimes:jpg,png,jpeg|max:2048' // Permitir imágenes opcionales
    ]);
    
    if ($validator->fails()) {      
      $this->response["code"] = 422;
      $this->response["msg"] = "Error de validación (0x0475)";
      $this->response["data"] = $validator->errors();
      return response()->json($this->response, 422);
    }
    
    $post = Post::where(['IdMask' => $request->IdPost])->first();
    if ($post == null) {
      $this->response["code"] = 409;
      $this->response["msg"] = "No existe el post ";
      return response()->json($this->response, 409);
    }
    
    $this->response["code"] = 200;
    $now = Carbon::now($this->time_zone);
    $old_foto = $post->imagen;//para borrar la imagen antigua
    $filename = "";
   
    if ($request->hasFile('imagen')) {
      
      $file = $request->file('imagen');
      $extension = $file->getClientOriginalExtension();
      $filename = $this->createCode(8);
      $filename .= ".";
      $filename .= $extension;      
      Storage::disk('local')->put($this->posts_folder . $filename, $file->get());

      Storage::disk('local')->delete($this->posts_folder . $old_foto);
    }
    
    // error_log('a borrar img '.$old_foto);
    


    $post->titulo = $data['titulo'];
    $post->contenido = $data['content'];

    if( $filename != ""){ $post->imagen = $filename; }    
    
    $post->updated_at = $now;    
    $post->updated_by = "front";    
    $post->save();
    
    $this->response["code"] = 200;
    $this->response["done"] = true;
    $this->response["data"] = [];
    $this->response["data"][0] = $filename;
    $this->response["msg"] = "Post actualizado correctamente";    
    return response()->json($this->response, 200);

  }//fin de actualizar

  public function borrar(Request $request) {
    $data = $request->all();
    
    $validator = Validator::make($data, [
      'id' => 'required|string|size:32'
    ]);
    
    if ($validator->fails()) {
      
      $this->response["code"] = 422;
      $this->response["msg"] = "Error de validación (0x7036)";
      $this->response["data"] = $validator->errors();
      return response()->json($this->response, 422);

    }

    $post = Post::where(['IdMask' => $request->id])->first();
    if ($post == null) {
      $this->response["code"] = 409;
      $this->response["msg"] = "No existe el post. ";
      return response()->json($this->response, 409);
    }

    if( $post->imagen != "" ){
      Storage::disk('local')->delete($this->autores_folder.$post->imagen );
    }

    //TODO: No se implemento lo de borrado logico, por ahora se borra todo
    $post->delete();
    $this->response["code"] = 200;
    $this->response["done"] = true;
    $this->response["data"] = [];
    $this->response["msg"] = "Post borrado correctamente";
    return response()->json($this->response, 200);

  }//fin de borrar

}//fin del controller
