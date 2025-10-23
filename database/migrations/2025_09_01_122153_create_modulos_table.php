<?php

// 2025_01_01_000003_create_modulos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulosTable extends Migration
{
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id(); // id_modulos
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modulos');
    }
}