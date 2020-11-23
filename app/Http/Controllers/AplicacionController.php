<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConceptoNivel;
use Symfony\Component\HttpFoundation\Response;

class AplicacionController extends Controller
{
    /**
     * Muestra todas las relaciones entre un
     * concepto y un nivel o grupo.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAplicaciones()
    {
        $objeto_db = ConceptoNivel::select('concepto_nivel.*','concepto.nombre AS nombre_concepto','nivel.nombre AS nombre_nivel')
            ->join('concepto','concepto_nivel.concepto_id', '=', 'concepto.concepto_id')
            ->join('nivel','concepto_nivel.nivel_id', '=', 'nivel.nivel_id')
            ->orderBy('concepto_nivel_id')->get();

        return response()->json(
            $objeto_db,
            Response::HTTP_ACCEPTED
        );
    }

     /**
     * Muestra las relaciones especificada por nombre del concepto o nombre de nivel .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAplicacion(Request $request)
    {
        $relacion = null;

        $objeto_db = ConceptoNivel::select('concepto_nivel.*','concepto.nombre AS nombre_concepto','nivel.nombre AS nombre_nivel')
            ->join('concepto','concepto_nivel.concepto_id', '=', 'concepto.concepto_id')
            ->join('nivel','concepto_nivel.nivel_id', '=', 'nivel.nivel_id');

        if(isset($request->nombre_concepto) && $request->nombre_concepto  != '') {
            $objeto_db->whereRaw("concepto.nombre LIKE '%$request->nombre_concepto%'");
        }

        if (isset($request->nombre_nivel) && $request->nombre_nivel != '') {
            $objeto_db->whereRaw("nivel.nombre LIKE '%$request->nombre_nivel%'");
        }

        $relacion = $objeto_db->orderBy('concepto_nivel_id')->get();

        return response()->json(
            $relacion,
            Response::HTTP_ACCEPTED
        );
    }


    /**
     * Crea una nueva relación entre concepto y nivel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createAplicacion(Request $request)
    {
        //Busca una relación entre el mismo concepto, nivel y semestre
        $existe = ConceptoNivel::where('concepto_id', '=', $request->concepto_id)
            ->where('nivel_id','=',$request->nivel_id)
            ->where('semestre','=',$request->semestre)->first();

        //Si encuentra una relación igual, retorna error
        if(!empty($existe)) {
            return response()->json(
                'La relación entre ese concepto, nivel y semestre ya existe.',
                Response::HTTP_CONFLICT
            );
        }

        if(!empty($request->concepto_id) && !empty($request->vigencia_inicial)
            && !empty($request->vigencia_final) ){
            $relacion = new ConceptoNivel;
            $relacion->concepto_id = $request->concepto_id;

            if($request->nivel_id){
                $relacion->nivel_id = $request->nivel_id;
            }

            if($request->semestre){
                $relacion->semestre = $request->semestre;
            }

            if($request->estatus){
                $relacion->estado = (int) $request->estatus;
            }

            $relacion->vigencia_inicial = $request->vigencia_inicial;
            $relacion->vigencia_final = $request->vigencia_final;

            $relacion->save();

            return response()->json(
                $relacion,
                Response::HTTP_CREATED
            );
        }else{
            return response()->json(
                'Falta llenar algún campo',
                Response::HTTP_CONFLICT
            );

        }
    }

    /**
     * Muestra todas las relaciones entre un
     * concepto y un nivel o grupo.
     *
     * @return \Illuminate\Http\Response
     */
    public function cargarAplicacion($id)
    {
        $objeto_db = ConceptoNivel::find($id);

        return response()->json(
            $objeto_db,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Actualiza una relación concepto - nivel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAplicacion(Request $request, $id)
    {
        // Busca la relación de concepto - nivel que se quiere actualizar
        $relacion = ConceptoNivel::where('concepto_nivel_id', '=', $id)->first();

        //Busca una relación(DIFERENTE AL QUE SE QUIERE ACTUALIZAR) entre el mismo concepto, nivel y semestre
        $existe = ConceptoNivel::where('concepto_id', '=', $request->concepto_id)
                    ->where('nivel_id','=',$request->nivel_id)
                    ->where('semestre','=',$request->semestre)
                    ->where('concepto_nivel_id', '!=', $id)->first();

        // Si existe una relacion igual
        if (!empty($existe)) {
            return response()->json(
                'La relación del concepto, nivel y semestre ya existe.',
                Response::HTTP_CONFLICT
            );
        }

        if(!empty($request->concepto_id) && !empty($request->vigencia_inicial) && !empty($request->vigencia_final) ){
            $relacion->concepto_id = $request->concepto_id;

            if($request->nivel_id){
                $relacion->nivel_id = $request->nivel_id;
            }

            if($request->semestre){
                $relacion->semestre = $request->semestre;
            }

            $relacion->estado = (int) $request->estatus;

            $relacion->vigencia_inicial = $request->vigencia_inicial;
            $relacion->vigencia_final = $request->vigencia_final;

            $relacion->save();

            return response()->json(
                $relacion,
                Response::HTTP_CREATED
            );
        }else{
            return response()->json(
                'Falta llenar algún campo',
                Response::HTTP_CONFLICT
            );

        }
    }

     /**
     * Elimina una relación concepto - nivel/semestre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAplicacion($id)
    {
        $relacion = ConceptoNivel::find($id);
        $relacion->delete();

        return response()->json(
            'La relación entre el concepto, nivel fue borrada.',
            Response::HTTP_ACCEPTED
        );
    }
}
