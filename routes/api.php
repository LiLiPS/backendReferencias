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

Route::group(['middleware' => 'api'], function() {
    /**************************************************************************************
     *                                  RUTAS GENERALES
     *************************************************************************************/
    // AUTENTICACIÓN
     Route::post('login', 'AuthController@login');
    Route::post('registro', 'AuthController@registro');

    // NIVELES
    Route::get('getNiveles','NivelController@getNiveles');

    /**************************************************************************************
     *                                  RUTAS PROTEGIDAS
     *************************************************************************************/
    Route::middleware('auth.jwt')->group(function () {
        // AUTENTICACIÓN
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');

        // REFERENCIAS
        Route::get('esPeriodo','ReferenciaController@esPeriodo');

        /**************************************************************
         *                      ADMINISTRADOR
         *************************************************************/
        Route::middleware('auth.role:1')->group(function () {

            // CONCEPTOS
            Route::get('getConceptos', 'ConceptosController@getConceptos');
            Route::post('getConcepto','ConceptosController@getConcepto');
            Route::post('createConcepto','ConceptosController@createConcepto');
            Route::put('updateConcepto/{id}','ConceptosController@updateConcepto');
            Route::delete('deleteConcepto/{id}','ConceptosController@deleteConcepto');

            // RELACIONES CONCEPTO-NIVEL
            Route::get('getAplicaciones','AplicacionController@getAplicaciones');
            Route::post('getAplicacion','AplicacionController@getAplicacion');
            Route::get('cargarAplicacion/{id}','AplicacionController@cargarAplicacion');
            Route::post('createAplicacion','AplicacionController@createAplicacion');
            Route::put('updateAplicacion/{id}','AplicacionController@updateAplicacion');
            Route::delete('deleteAplicacion/{id}','AplicacionController@deleteAplicacion');

            // REFERENCIAS

        });

        /**************************************************************
         *                          ESTUDIANTE
         *************************************************************/
        Route::middleware('auth.role:2')->group(function () {
            // REFERENCIA DE REINSCRIPCIÓN
            Route::post('createRefReinscripcion/{id}','ReferenciaController@createRefReinscripcion');
            Route::get('getRefReinscripcion/{id}','ReferenciaController@getRefReinscripcion');
        });
    });
});
