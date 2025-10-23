<?php

// 2025_01_01_000001_create_aulas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAulasTable extends Migration
{
    public function up()
    {
        Schema::create('aulas', function (Blueprint $table) {
            $table->id(); // id
            $table->string('nombre', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aulas');
    }
}
