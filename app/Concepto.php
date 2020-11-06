<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $filable = [
        'nombre',
        'descripcion',
        'monto',
        'estado'
    ];

    protected $table = "concepto";

    protected $primaryKey = "concepto_id";

    public $timestamps = false;
}
