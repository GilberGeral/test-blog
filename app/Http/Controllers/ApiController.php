<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller{

  public function __construct(){

  }

  public function autorCrear(Request $req){
    $data = $req->all();
    $res=[];
    $res["msg"] = "OK";
    $res["code"] = 200;
    $res["data"] = [];
    return response()->json($data);
  }
  
}
