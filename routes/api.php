<?php
use Illuminate\Http\Request;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\Routing\ApiGroup as Api;
use \App\JsonApi\Registration;
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
JsonApi::register('v1', ['namespace' => 'Api'], Registration::getJSONApiRegistration());