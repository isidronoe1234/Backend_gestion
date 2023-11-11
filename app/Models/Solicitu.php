<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitu extends Model
{
    use HasFactory;

    protected $fillable=[
        'NUE',
        'ruta_archivo',
    ];
}
