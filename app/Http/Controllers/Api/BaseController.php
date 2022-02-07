<?php
namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\http\Controllers\Controller;
use CloudCreativity\LaravelJsonApi\Http\Controllers\EloquentController;
use CloudCreativity\JsonApi\Contracts\Http\Requests\RequestInterface;
use CloudCreativity\LaravelJsonApi\Services\JsonApiService;

/*
 * controller is building automaticly Model and JsonApiHydrator class from request path  
 */
class BaseController extends EloquentController
{
  
  public function __construct(Request $request, JsonApiService $service)
  {
    $path = explode("/", $request->getPathInfo());
    $resource_type = studly_case($path[3]);
    $model_class   = $resource_type == "Media" ? $resource_type : str_singular($resource_type);
    
    $modelClassName = "App\\" . $model_class;
    $hydratorClassName = "App\\JsonApi\\$resource_type\\Hydrator";
    parent::__construct(new $modelClassName(), new $hydratorClassName($service));
  }
  
   /**
     * @param RequestInterface $request
     * @return Response
    */
   /*
    public function readRelatedResource(RequestInterface $request)
    {
        $model = $this->getRecord($request);
        $key = $this->keyForRelationship($request->getRelationshipName());
        if ($key === "versions") {
            return $this
                ->reply()
                ->content($model->revisionHistory);
        } else {
            return $this
                ->reply()
                ->content($model->{$key});
        }
    }
    */
   
}
