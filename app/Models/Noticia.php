<?php

// app/Models/Noticia.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = ['titulo','contenido','fecha','imagen'];


     public function noticias()
        {
            return $this->hasMany(Noticia::class);
        }
}