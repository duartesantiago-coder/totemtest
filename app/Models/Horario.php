<?php

// app/Models/Horario.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'aula_id','modulo_id','curso_id','user_id','dia'
    ];

    public function aula() { return $this->belongsTo(Aula::class, 'aula_id'); }
    public function modulo() { return $this->belongsTo(Modulo::class, 'modulo_id'); }
    public function curso() { return $this->belongsTo(Curso::class, 'curso_id'); }
    public function user() { return $this->belongsTo(User::class); }

    
}