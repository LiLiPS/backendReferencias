<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfSistema extends Model
{

    protected $fillable = [
        'nombre',
        'abreviatura',
        'fecha_inicial',
        'fecha_final',
        'estado',
    ];

    protected $primaryKey = 'conf_sistema_id';

    public $timestamps = false;

    protected $table = 'conf_sistema';
}
