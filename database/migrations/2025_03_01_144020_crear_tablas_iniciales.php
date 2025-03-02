<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up() {
    Schema::create('autores', function (Blueprint $table) {
      $table->id('IdAutor')->unsigned();
      $table->string('IdMask', 16)->unique();
      $table->string('Nombre', 64);
      $table->string('foto', 32)->nullable();
      $table->string('email', 64)->unique();
      $table->dateTime('created_at')->useCurrent();
      $table->string('created_by', 16)->nullable();
      $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable();
      $table->string('updated_by', 16)->nullable();
    });

    Schema::create('posts', function (Blueprint $table) {
      $table->id('IdPost')->unsigned();
      $table->string('IdMask', 32)->unique();
      $table->unsignedBigInteger('IdAutor');
      $table->string('titulo', 64);
      $table->mediumText('contenido');
      $table->string('imagen', 32)->nullable();
      $table->dateTime('created_at')->useCurrent();
      $table->string('created_by', 16)->nullable();
      $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable();
      $table->string('updated_by', 16)->nullable();

      $table->foreign('IdAutor')->references('IdAutor')->on('autores')->onDelete('cascade');
    });
  }

  public function down() {
    Schema::dropIfExists('posts');
    Schema::dropIfExists('autores');
  }
};