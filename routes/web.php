<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'Debug\JsonApiDocController@index');

// these all request methods are only GET´s we use them to provide a url against testing AuthorizeMiddleware
Route::get('/api/v1', 'Debug\JsonApiDocController@index');
Route::post('/api/v1', 'Debug\JsonApiDocController@index');
Route::patch('/api/v1', 'Debug\JsonApiDocController@index');
Route::delete('/api/v1', 'Debug\JsonApiDocController@index');

// generate json api as swagger document with content-type: text/swagger
Route::get('/api/v1.yaml', 'Debug\JsonApiDocController@swagger');
