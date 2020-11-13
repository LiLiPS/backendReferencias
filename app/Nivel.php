<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $fillable = [
        'nombre'
    ];

    protected $table = "nivel";

    protected $primaryKey = "nivel_id";

    public $timestamps = false;
}
