<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model {
  use HasFactory;

  protected $table = 'autores';

  protected $primaryKey = 'IdAutor';

  public $incrementing = true; 
  protected $keyType = 'int'; 
  public $timestamps = true; 

  protected $fillable = [
    'IdMask',
    'Nombre',
    'foto',
    'email',
    'created_by',
    'updated_by'
  ];

  protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
  ];
  
  protected $dates = ['created_at', 'updated_at'];

  public function posts() {
    return $this->hasMany(Post::class, 'IdAutor', 'IdAutor');
  }

  public function countPosts(){
    return $this->posts()->count();
  }
  
}//fin de la clase