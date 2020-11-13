<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get("listarConceptos", "ConceptosController@index");
//Route::resource("concepto", "ConceptosController");

// Buscar todos los conceptos
Route::get('getConceptos','ConceptosController@getConceptos');

// Buscar un concepto especificado por su FK área académica o nombre de concepto
Route::post('getConcepto','ConceptosController@getConcepto');

// Crear un concepto
Route::post(
    'createConcepto','ConceptosController@createConcepto'
);

// Actualizar un concepto
Route::put('updateConcepto/{id}','ConceptosController@updateConcepto');

// Dar de baja a un concepto
Route::delete('deleteConcepto/{id}','ConceptosController@deleteConcepto'
);

/*******************************************
 *         OBTENER NIVELES
 * ****************************************/
Route::get('niveles','NivelController@getNiveles');
