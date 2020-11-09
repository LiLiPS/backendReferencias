<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    protected $filable = [
        'usuario_id',
        'concepto_id',
        'fecha_generada',
        'fecha_expiracion',
        'monto',
        'monto_pagado',
        'numero_ref_banco',
        'fecha_pagado',
        'tipo_pago',
        'cantidad_solicitada',
        'estado'
    ];

    protected $table = "referencia";

    protected $primaryKey = "referencia_id";

    public $timestamps = false;
}
