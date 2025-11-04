<?php

// 2025_01_01_000006_create_horarios_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id(); // id_horario
            $table->unsignedBigInteger('aula_id')->nullable();
            $table->unsignedBigInteger('modulo_id');
            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('user_id')->nullable(); // preceptor/creador
            $table->enum('dia', ['1', '2', '3', '4', '5']);      
            $table->timestamps();

            $table->foreign('aula_id')->references('id')->on('aulas')->restrictOnDelete();
            $table->foreign('modulo_id')->references('id')->on('modulos')->restrictOnDelete();
            $table->foreign('curso_id')->references('id')->on('cursos')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();


            $table->index(['aula_id','dia','modulo_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('horarios');
    }
}