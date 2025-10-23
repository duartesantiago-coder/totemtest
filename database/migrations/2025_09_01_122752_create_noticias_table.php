<?php

// 2025_01_01_000004_create_noticias_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->text('contenido');
            $table->dateTime('fecha')->nullable();
            $table->string('imagen')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('noticias');
    }
}
