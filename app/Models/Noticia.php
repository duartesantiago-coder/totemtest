<?php

// app/Models/Noticia.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'contenido', 'autor_id', 'publicada', 'imagen'];
    
    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }
}