<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AutorController extends Controller {
  public $default_image;
  public function __construct() {
    parent::__construct();
    $this->long_mask=8;
    $this->default_image = "autor_foto.png";
  }

  public function crear(Request $request) {
    $data = $request->all();
        
    $validator = Validator::make($data, [
      'nombre' => 'required|string|min:3',
      'email' => 'required|email|max:64',
      'foto' => 'nullable|file|mimes:jpg,png,jpeg|max:2048' // Permitir imágenes opcionales
    ]);
    
    if ($validator->fails()) {
      
      $this->response["code"] = 422;
      $this->response["msg"] = "Error de validación";
      $this->response["data"] = $validator->errors();
      return response()->json($this->response, 422);
    }
    
    $autor = Autor::where('email', $request->email)->first();
    if ($autor != null) {
      $this->response["code"] = 409;
      $this->response["msg"] = "Ya existe un autor con ese email";
      return response()->json($this->response, 409);
    }

    $this->response["code"] = 200;
    $now = Carbon::now($this->time_zone);
    $filename = $this->default_image;
   
    if ($request->hasFile('foto')) {
      
      $file = $request->file('foto');
      $extension = $file->getClientOriginalExtension();
      $filename = $this->createCode(8);
      $filename .= ".";
      $filename .= $extension;      
      Storage::disk('local')->put($this->autores_folder . $filename, $file->get());
     
    }

    $autor = new Autor();    
    $autor->IdMask = $this->createCode($this->long_mask);
    $this->createCode($this->long_mask);
    $autor->Nombre = $data['nombre'];
    $autor->email = $data['email'];
    $autor->foto = $filename;
    $autor->created_at = $now;
    $autor->updated_at = $now;
    $autor->created_by = "front";
    $autor->updated_by = "front";    
    $autor->save();
    
    $this->response["code"] = 200;
    $this->response["done"] = true;
    $this->response["data"] = [];
    $this->response["msg"] = "Autor creado correctamente";    
    return response()->json($this->response, 200);
  }

  public function getList(){
    
    $this->response["data"] = Autor::select( 'IdMask AS Id', 'nombre', 'email','foto', 'created_at')->orderByDesc('created_at')->get()->toArray();
    // dd($this->response["data"]);
    $this->response["code"] = 200;
    $this->response["done"] = true;
    return response()->json($this->response, 200);
  }

  
  public function actualizar(Request $request) {

    $data = $request->all();
    
    $validator = Validator::make($data, [
      'id' => 'required|string|size:16',
      'nombre' => 'required|string|min:3',
      'email' => 'required|email|max:64',
      'foto' => 'nullable|file|mimes:jpg,png,jpeg|max:2048' // Permitir imágenes opcionales
    ]);
    
    if ($validator->fails()) {
      
      $this->response["code"] = 422;
      $this->response["msg"] = "Error de validación (0x0056)";
      $this->response["data"] = $validator->errors();
      return response()->json($this->response, 422);
    }
    
    $autor = Autor::where(['email'=> $request->email, 'IdMask' => $request->id])->first();
    if ($autor == null) {
      $this->response["code"] = 409;
      $this->response["msg"] = "No existe el autor ";
      return response()->json($this->response, 409);
    }
    
    $this->response["code"] = 200;
    $now = Carbon::now($this->time_zone);
    $old_foto = $autor->foto;//para borrar la foto antigua
    $filename = "";
   
    if ($request->hasFile('foto')) {
      
      $file = $request->file('foto');
      $extension = $file->getClientOriginalExtension();
      $filename = $this->createCode(8);
      $filename .= ".";
      $filename .= $extension;      
      Storage::disk('local')->put($this->autores_folder . $filename, $file->get());
     
    }
      
    
    $this->createCode($this->long_mask);
    $autor->Nombre = $data['nombre'];
    $autor->email = $data['email'];

    if( $filename != ""){ $autor->foto = $filename; }    
    
    $autor->updated_at = $now;    
    $autor->updated_by = "front";    
    $autor->save();
    
    $this->response["code"] = 200;
    $this->response["done"] = true;
    $this->response["data"] = [];
    $this->response["data"][0] = $filename;
    $this->response["msg"] = "Autor actualizado correctamente";    
    return response()->json($this->response, 200);

  }//fin de actualizar
  
  public function borrar(Request $request) {
    $data = $request->all();
    
    $validator = Validator::make($data, [
      'id' => 'required|string|size:16'
    ]);
    
    if ($validator->fails()) {
      
      $this->response["code"] = 422;
      $this->response["msg"] = "Error de validación (0x0057)";
      $this->response["data"] = $validator->errors();
      return response()->json($this->response, 422);

    }

    $autor = Autor::where(['IdMask' => $request->id])->first();
    if ($autor == null) {
      $this->response["code"] = 409;
      $this->response["msg"] = "No existe el autor. ";
      return response()->json($this->response, 409);
    }

    if( $autor->foto != $this->default_image ){
      Storage::disk('local')->delete($this->autores_folder.$autor->foto );
    }

    //TODO: No se implemento lo de borrado logico, por ahora se borra todo
    $autor->delete();
    $this->response["code"] = 200;
    $this->response["done"] = true;
    $this->response["data"] = [];
    $this->response["msg"] = "Autor borrado correctamente";
    return response()->json($this->response, 200);

  }//fin de borrar

}//fin del controller
