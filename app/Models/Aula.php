<?php

// app/Models/Aula.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $fillable = ['nombre'];

    

    // Un aula tiene muchos horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}