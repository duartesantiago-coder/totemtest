<?php

// 2025_01_01_000004_create_noticias_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('contenido');
            $table->unsignedBigInteger('autor_id')->nullable();
            $table->boolean('publicada')->default(false);
            $table->timestamps();
            $table->foreign('autor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('noticias');
    }
};
