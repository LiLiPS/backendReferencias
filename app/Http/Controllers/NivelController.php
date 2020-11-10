<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nivel;
use Symfony\Component\HttpFoundation\Response;

class NivelController extends Controller
{
     /**
     * Muestra todos los niveles.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNiveles()
    {
        $niveles =  Nivel::get();

        return response()->json(
            $niveles,
            Response::HTTP_ACCEPTED
        );
    }
}
