<?php

// app/Models/Modulo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['anio','division'];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
