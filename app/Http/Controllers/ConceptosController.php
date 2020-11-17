<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Concepto;
use Symfony\Component\HttpFoundation\Response;

class ConceptosController extends Controller
{

    /**
     * Muestra todos los conceptos.
     *
     * @return \Illuminate\Http\Response
     */
    public function getConceptos()
    {
        //Busca conceptos no eliminados
        $conceptos = Concepto::orderBy('nombre')->get();

        return response()->json(
            $conceptos,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Muestra un concepto especificado por su NOMBRE.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getConcepto(Request $request)
    {
        $concepto = null;

        $objeto_db = Concepto::whereRaw("nombre LIKE '%$request->nombre%'");

        $concepto = $objeto_db->orderBy('nombre')->get();

        return response()->json(
            $concepto,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Crea un concepto
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createConcepto(Request $request)
    {
        // Busca un concepto no eliminado con el mismo nombre
        $existe = Concepto::where('nombre', '=', $request->nombre)->first();

        // Si encuentra un concepto igual con nombre, retorna error.
        if(!empty($existe)) {
            return response()->json(
                'El concepto con ese nombre ya existe.',
                Response::HTTP_CONFLICT
            );
        }else{

            $concepto = new Concepto;
            $estado = (int) $request->estado;
            $concepto->nombre = $request->nombre;
            $concepto->descripcion = $request->descripcion;
            $concepto->monto = $request->monto;
            $concepto->estado = $estado;

            $concepto->save();

            return response()->json(
                $concepto,
                Response::HTTP_CREATED
            );
        }
    }

    /**
     * Actualiza uno o varios atributos de un concepto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateConcepto(Request $request, $id)
    {
        // Busca el concepto que se quiere actualizar
        $concepto = Concepto::where('concepto_id', '=', $id)->first();

        // Si se quiere actualizar el nombre
        if (isset($request->nombre)) {
            // Busca un concepto (DIFERENTE AL QUE SE QUIERE ACTUALIZAR) no eliminado con el mismo nombre
            $existe = Concepto::where('nombre', '=', $request->nombre)->where('concepto_id', '!=', $id)->first();

            // Si existe un concepto con el mismo nombre
            if (!empty($existe)) {
                return response()->json(
                    'El concepto con ese nombre ya existe.',
                    Response::HTTP_CONFLICT
                );
            }else{
                $estado = (int) $request->estado;
                $concepto->nombre = $request->nombre;
                $concepto->descripcion = $request->descripcion;
                $concepto->monto = $request->monto;
                $concepto->estado = $estado;

                $concepto->save();

                return response()->json(
                    $concepto,
                    Response::HTTP_ACCEPTED
                );
            }
        }
    }

    /**
     * Elimina un concepto
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteConcepto($id)
    {
        //Busca concepto con el id enviado
        $concepto = Concepto::find($id);
        $concepto->delete();

        return response()->json(
            'El concepto fue borrado.',
            Response::HTTP_ACCEPTED
        );
    }

}
