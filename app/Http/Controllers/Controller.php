<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController{
  use AuthorizesRequests, ValidatesRequests;
  public $response;
  public $time_zone;
  public $autores_folder;
  public $long_mask;
  public function __construct() {
    $this->response = [
      'code' => 200,
      'done' => false,
      'msg' => '',
      'data' => []
    ];

    $this->time_zone = "America/Bogota";
    $this->autores_folder = "public/autores/";
  }//fin de contrustor

  public function createCode($longitud = 8) {
    //devuelve un string el doble de largo del indicado en el argumento     
    $bytes = random_bytes($longitud);
    return bin2hex($bytes);
  }
}
