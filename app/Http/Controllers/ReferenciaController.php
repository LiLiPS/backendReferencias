<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Concepto;
use App\Referencia;
use App\Usuario;
use App\ConceptoNivel;
use App\RolUsuario;
use Symfony\Component\HttpFoundation\Response;

class ReferenciaController extends Controller
{
    public $concepto;
    public $conceptoSegundo;
    public $conceptoTercero;
    public $conceptoQuinto;
    public $conceptoSeptimo;

    /**
     * Crea una referencia de reinscripción.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRefReinscripcion($id_usuario)
    {
        $this->concepto = null;
        $vigencia = null;
        $usuario = Usuario::find($id_usuario);
        $rol_usuario = RolUsuario::where('usuario_id', '=', $id_usuario)->first();

        $this->getConceptosReinscripcion();

        // Obtener vigencia de concepto en el nivel y semestre
        $vigenciaSegundo = ConceptoNivel::where('concepto_id', '=', $this->conceptoSegundo->concepto_id)
            ->select('concepto_nivel.*')->first();

        $vigenciaTercero = ConceptoNivel::where('concepto_id', '=', $this->conceptoTercero->concepto_id)
            ->select('concepto_nivel.*')->first();

        $vigenciaQuinto = ConceptoNivel::where('concepto_id', '=', $this->conceptoQuinto->concepto_id)
            ->select('concepto_nivel.*')->first();

        $vigenciaSeptimo = ConceptoNivel::where('concepto_id', '=', $this->conceptoSeptimo->concepto_id)
            ->select('concepto_nivel.*')->first();

        // Acomodar concepto y vigencias por semestres
        switch($usuario->semestre) {
            case 2:
                $this->concepto = $this->conceptoSegundo;
                $vigencia = $vigenciaSegundo;
                break;
            case 3 || 4:
                $this->concepto = $this->conceptoTercero;
                $vigencia = $vigenciaTercero;
                break;
            case 5 || 6:
                $this->concepto = $this->conceptoQuinto;
                $vigencia = $vigenciaQuinto;
                break;
            case 7 || 8 || 9 || 10 || 11 || 12 || 13 || 14 || 15 || 16:
                $this->concepto = $this->conceptoSeptimo;
                $vigencia = $vigenciaSeptimo;
        }

        $referencia = new Referencia;

        //Para generar el número de referencia
        $ref = $this->RUTINA8250POSICIONES([
            'tipo_persona'=>$rol_usuario->rol_id,                             // tipo usuario
            'control'=>$usuario->numero_control,                                // número de control
            // llave primaria de concepto, cat_concepto
            'servicio'=>str_pad($this->concepto->concepto_id, 3, '0', STR_PAD_LEFT),
            'valorvariable'=>2,
            'monto'=>$this->concepto->monto,                                    // monto, concepto
            'yearC'=>date("Y", strtotime($vigencia->vigencia_final)),   // año, vigencia final, concepto_nivel
            'mesC'=>date("m", strtotime($vigencia->vigencia_final)),    // mes, vigencia final, concepto_nivel
            'diaC'=>date("d", strtotime($vigencia->vigencia_final))     // dia, vigencia final, concepto_nivel
        ]);

        // Guardar los campos de la referencia
        $referencia->usuario_id = $id_usuario;
        $referencia->concepto_id = $this->concepto->concepto_id;
        $referencia->fecha_generada = date('Y-m-d H:i:s');
        $referencia->fecha_expiracion = $vigencia->vigencia_final;
        $referencia->numero_ref_banco = $ref;
        $referencia->monto = $this->concepto->monto;
        $referencia->cantidad_solicitada = 1;
        $referencia->monto_pagado = $this->concepto->monto * 1;  // Monto * cantidad = monto total

        $referencia->save();

        return response()->json(
            $referencia,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Muestra una referencia especificada por su PK.
     *
     * @param $id_usuario
     * @return \Illuminate\Http\Response
     */
    public function getRefReinscripcion($id_usuario)
    {
        $this->concepto = null;
        $usuario = Usuario::find($id_usuario);

        $this->getConceptosReinscripcion();

        switch($usuario->SEMESTRE) {
            case 2:
                $this->concepto = $this->conceptoSegundo;
                break;
            case 3 || 4:
                $this->concepto = $this->conceptoTercero;
                break;
            case 5 || 6:
                $this->concepto = $this->conceptoQuinto;
                break;
            case 7 || 8 || 9 || 10 || 11 || 12 || 13 || 14 || 15 || 16:
                $this->concepto = $this->conceptoSeptimo;
        }

        $referencia = Referencia::join('usuario', 'referencia.usuario_id', '=', 'usuario.usuario_id')
            ->join('concepto', 'referencia.concepto', '=', 'concepto.concepto')
            ->where('usuario_id', '=', $id_usuario)
            ->where('concepto_id', '=', $this->concepto->concepto_id)
            ->select('referencia.*', 'usuario.nombre AS nombre_usuario', 'usuario.primer_apellido',
                'usuario.segundo_apellido', 'concepto.nombre AS nombre_concepto')->first();

        if (empty($referencia)) {
            return response()->json(
                'No existe ninguna referencia con el ID enviado.',
                Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                $referencia,
                Response::HTTP_ACCEPTED
            );
        }
    }

    /**
     * Obtiene conceptos de reinscripción para
     * cada semestre.
     *
     */
    public function getConceptosReinscripcion() {
        $this->conceptoSegundo = Concepto::where('concepto.nombre', '=', 'Matriculación 2o semestre Agosto Diciembre 2020')
            ->select('concepto.*')->first();

        $this->conceptoTercero = Concepto::where('concepto.nombre', '=', 'Matriculación 3o y 4o semestre Agosto Diciembre 2020')
            ->select('concepto.*')->first();

        $this->conceptoQuinto = Concepto::where('concepto.nombre', '=', 'Matriculación 5o y 6o semestre Agosto Diciembre 2020')
            ->select('concepto.*')->first();

        $this->conceptoSeptimo = Concepto::where('concepto.nombre', '=', 'Matriculación de 7o semestre en adelante Agosto Diciembre 2020')
            ->select('concepto.*')->first();
    }

     /**
     * @param $datosReferencia
     * @return string
     */

    public static function RUTINA8250POSICIONES($datos)
    {
        $Amonto = array(7, 3, 1); //arreglo para obtener el importe concensado
        $ADV = array(11, 13, 17, 19, 23); //arreglo de digito verificador
        $letra = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5, 6, 7, 8, 9);

        $referencia = strtoupper($datos['tipo_persona'] . $datos['control'] . $datos['servicio']); //tipoalumno.control.servicio
        $rev = "";
        $ValorVariable = $datos['valorvariable'];
        foreach (str_split($referencia) as $char) {
            if ((ord($char) > 64 && ord($char) < 91)) {
                $rev .= $letra[ord($char) - 65];
            } else {
                $rev .= $char;
            }
        }
        $referencia = $rev;
        $monto = $datos['monto'];
        if (strpos($monto, '.') === false) {
            $monto = number_format($monto, 2, '.', '');
        }
        $fecha = "" . ((($datos['yearC'] - 2014) * 372) + (($datos['mesC'] - 1) * 31) + ($datos['diaC'] - 1));
        $monto = strrev(str_replace('.', '', $monto));
        $i = 0;
        $suma = 0;
        foreach (str_split($monto) as $dig) {
            $suma += ($Amonto[$i] * $dig);
            $i++;
            if ($i == count($Amonto)) {
                $i = 0;
            }
        }
        $monotoConde = "" . ($suma % 10);
        $referenciatemp = strrev($referencia . $fecha . '' . $monotoConde . '' . $ValorVariable);
        $i = 0;
        $suma = 0;
        foreach (str_split($referenciatemp) as $dig) {
            $suma += ($ADV[$i] * $dig);
            $i++;
            if ($i == count($ADV)) {
                $i = 0;
            }
        }
        $digitoVerificador = "" . (($suma % 97) + 1);
        $DV = (($suma % 97) + 1);
        if ($DV < 10) {
            $digitoVerificador = "0" . (($suma % 97) + 1);
        } else {
            $digitoVerificador = "" . (($suma % 97) + 1);
        }
        return $referencia . $fecha . $monotoConde . $ValorVariable . $digitoVerificador;
    }
}
