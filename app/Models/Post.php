<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
  use HasFactory;

  protected $table = 'posts';

  protected $primaryKey = 'IdPost';

  public $incrementing = true; 
  protected $keyType = 'int'; 
  public $timestamps = true; 

  protected $fillable = [
    'IdPost',
    'IdMask',
    'IdAutor',
    'titulo',
    'contenido',
    'imagen',    
    'created_by',
    'updated_by'
  ];

  protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
  ];
  
  protected $dates = ['created_at', 'updated_at'];
  
  public function autor() {
    return $this->belongsTo(Autor::class, 'IdAutor', 'IdAutor');
  }
}//fin de la clase