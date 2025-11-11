<?php

// app/Models/Noticia.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = ['titulo', 'contenido', 'autor_id', 'publicada'];
    
    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }
}