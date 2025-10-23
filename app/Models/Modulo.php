<?php

// app/Models/Modulo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $fillable = ['hora_inicio','hora_final'];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}