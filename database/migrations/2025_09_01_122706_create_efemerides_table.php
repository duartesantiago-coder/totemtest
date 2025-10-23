<?php

// 2025_01_01_000005_create_efemerides_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEfemeridesTable extends Migration
{
    public function up()
    {
        Schema::create('efemerides', function (Blueprint $table) {
            $table->id();
            $table->text('contenido');
            $table->dateTime('fecha')->nullable();
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('efemerides');
    }
}
