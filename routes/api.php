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
    Route::post('login', 'AuthController@login');
    Route::post('registro', 'AuthController@registro');

    /**************************************************************************************
     *                                  RUTAS PROTEGIDAS
     *************************************************************************************/
    Route::middleware('auth.jwt')->group(function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');

        /**************************************************************
         *                      ADMINISTRADOR
         *************************************************************/
        Route::middleware('auth.role:1')->group(function () {
            // NIVELES
            Route::get('getNiveles','NivelController@getNiveles');

            // CONCEPTOS
            Route::get('getConceptos', 'ConceptosController@getConceptos');
            Route::post('getConcepto','ConceptosController@getConcepto');
            Route::post('createConcepto','ConceptosController@createConcepto');
            Route::put('updateConcepto/{id}','ConceptosController@updateConcepto');
            Route::delete('deleteConcepto/{id}','ConceptosController@deleteConcepto');

            // RELACIONES CONCEPTO-NIVEL
            Route::get('getAplicaciones','AplicacionController@getAplicaciones');
            Route::post('getAplicacion','AplicacionController@getAplicacion');
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
        });
    });
});
