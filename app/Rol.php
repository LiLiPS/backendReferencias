<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = [
        'nombre',
        'abreviatura',
        'estado'
    ];

    protected $table = "rol";

    protected $primaryKey = "rol_id";

    public $timestamps = false;
}
