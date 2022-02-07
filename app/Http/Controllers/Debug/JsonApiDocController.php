<?php
namespace App\Http\Controllers\Debug;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use \App\Debug\JsonDocApi;
use CloudCreativity\JsonApi\Utils\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use \Exception as Exception;

class JsonApiDocController extends Controller
{
  
  public function index(Request $request) {
    $jsonDocApi = new JsonDocApi();
    
    return view('debug.jsondoc', compact('jsonDocApi'));
  }
  
  public function swagger(Request $request) {
    $jsonDocApi = new JsonDocApi();
    
    return response( view('debug.jsondoc-swagger', compact('jsonDocApi')) )
        ->header('Content-Type', 'text/yaml');
  }

}
