<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'nivel_id',
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'curp',
        'sexo',
        'telefono',
        'correo_electronico',
        'password',
        'numero_control',
        'semestre',
        'estado'
    ];

    protected $table = "usuario";

    protected $primaryKey = "usuario_id";

    public $timestamps = false;
}
