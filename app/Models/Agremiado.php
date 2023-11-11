<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agremiado extends Model
{
    use HasFactory;

    protected $fillable=[
        'a_paterno',
        'a_materno',
        'nombre',
        'sexo',
        'NUP',
        'NUE',
        'RFC',
        'NSS',
        'f_nacimiento',
        'telefono',
        'cuota',
        'status',

    ];
}
