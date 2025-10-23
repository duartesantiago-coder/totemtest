<?php

// app/Models/Efemeride.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Efemeride extends Model
{
    protected $fillable = ['contenido','fecha','imagen'];
}