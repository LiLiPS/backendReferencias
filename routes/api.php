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

/**************************************************************************************
 *                                  AUTENTICACIÓN
 *************************************************************************************/
Route::group(['middleware' => 'api','prefix' => 'auth'], function() {
    Route::post('login', 'AuthController@login');
    Route::post('registro', 'AuthController@registro');

    Route::middleware('auth.jwt')->group(function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });
});

/**************************************************************************************
 *                          RUTAS PROTEGIDAS DEL SISTEMA
 *************************************************************************************/
Route::middleware('auth.jwt')->group(function () {
});


/**************************************************************************************
 *                                      CONCEPTOS
 *************************************************************************************/
// Buscar todos los conceptos
Route::get('getConceptos','ConceptosController@getConceptos');
// Buscar un concepto especificado por su FK área académica o nombre de concepto
Route::post('getConcepto','ConceptosController@getConcepto');
// Crear un concepto
Route::post('createConcepto','ConceptosController@createConcepto');
// Actualizar un concepto
Route::put('updateConcepto/{id}','ConceptosController@updateConcepto');
// Dar de baja a un concepto
Route::delete('deleteConcepto/{id}','ConceptosController@deleteConcepto');

/**************************************************************************************
 *                                          NIVELES
 *************************************************************************************/
//Obtener niveles
Route::get('getNiveles','NivelController@getNiveles');

/**************************************************************************************
 *                                      CONCEPTO-NIVEL
 *************************************************************************************/
//Obtener todas las relaciones concepto - nivel
Route::get('getAplicaciones','AplicacionController@getAplicaciones');
// Obtener relaciones por nombre de concepto o nombre de nivel
Route::post('getAplicacion','AplicacionController@getAplicacion');
// Crear una relación concepto - nivel
Route::post('createAplicacion','AplicacionController@createAplicacion');
// Actualizar una relación concepto - nivel
Route::put('updateAplicacion/{id}','AplicacionController@updateAplicacion');
//Elimina una relación concepto - nivel
Route::delete('deleteAplicacion/{id}','AplicacionController@deleteAplicacion');
