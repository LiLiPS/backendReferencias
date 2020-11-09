<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolUsuario extends Model
{
    protected $filable = [
        'rol_id',
        'usuario_id'
    ];

    protected $table = "rol_usuario";

    protected $primaryKey = "rol_usuario_id";

    public $timestamps = false;
}
