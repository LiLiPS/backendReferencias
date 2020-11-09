<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConceptoNivel extends Model
{
    protected $filable = [
        'concepto_id',
        'nivel_id',
        'vigencia_inicial',
        'vigencia_final',
        'semestre',
        'estado'
    ];

    protected $table = "concepto_nivel";

    protected $primaryKey = "concepto_nivel_id";

    public $timestamps = false;
}
