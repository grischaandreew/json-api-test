<?php

namespace App\Debug;

use \App\Debug\JsonDocResource;
use \App\JsonApi\Registration;
use CloudCreativity\LaravelJsonApi\Http\Requests\RequestInterpreter;
use Illuminate\Http\Request;

/**
 * generate json api documentation from CloudCreativity\LaravelJsonApi package
 * the class documentation of validator will be used for documenation markdown string
 *
 */
class JsonDocApi
{
  public $resources;
  public function __construct() {
      $this->resources = array();
      
      Registration::getJSONApiRegistration()($this);
    
      $jsonDocResources = $this->resources;

      $api = json_api('v1');
      
      $resources = $api->getResources()->getIterator();

      $factory = $this->_accessProtected($api, 'factory');
      $request = Request::capture();
      $requestInterpreter = new RequestInterpreter($request);
    
      foreach ($resources as $resource) {
        $schema = $resource->getSchemaFqn();
        $validator = $resource->getValidatorsFqn();
        if( $validator == null ) {
          $validator = str_replace('\Schema', '\Validator', $resource->getSchemaFqn());
        }
        
        $v = new $validator($api, $requestInterpreter, $factory);
        
        $s = new $schema($factory);
      
        $attributes = $this->_renameUnderscore( $this->_accessProtected($s, 'attributes') );
        $attributesIncluded = $this->_renameUnderscore($this->_accessProtected($s, 'attributesIncluded') );
      
        $allowedFilteringParameters = $this->_renameUnderscore( $this->_accessProtected($v, 'allowedFilteringParameters') );
        $allowedIncludePaths        = $this->_renameUnderscore( $this->_accessProtected($v, 'allowedIncludePaths') );
        $queryRules                 = $this->_renameUnderscore( $this->_accessProtected($v, 'queryRules') );
        $allowedSortParameters      = $this->_renameUnderscore( $this->_accessProtected($v, 'allowedSortParameters') );
        
        
        $attributeRules      = $this->_renameUnderscore( $this->_accessProtectedFunction($v, 'attributeRules') );
        
        $name = $s->getResourceType();
        if (!isset($resources[$name])) {
          continue;
        }
      
        $res = $resources[$name];
        $jsonDocResource = $jsonDocResources[$name];  
        
        
        $jsonDocResource->documentation = $this->_getDocumentation($v);
        
        $jsonDocResource->attributes = is_array($attributes) ? $attributes : [];
        $jsonDocResource->attributesIncluded = $attributesIncluded;
        $jsonDocResource->attributeRules = $attributeRules;
      
        $jsonDocResource->allowedFilteringParameters = $allowedFilteringParameters;
        $jsonDocResource->allowedIncludePaths = $allowedIncludePaths;
        $jsonDocResource->queryRules = $queryRules;
        $jsonDocResource->allowedSortParameters = $allowedSortParameters;
      }
  }

  public function resource($resourceType, array $options = []) {
    $resource = new JsonDocResource;
    $resource->name = $resourceType;
    $resource->hasMany = array();
    $resource->hasOne = array();

    $hasMany = array_key_exists('has-many', $options)?$options['has-many']:[];
    $hasOne = array_key_exists('has-one', $options)?$options['has-one']:[];

    if (is_array($hasMany)) {
      $resource->hasMany = $hasMany;
    } else {
      $resource->hasMany[] = $hasMany;
    }

    if (is_array($hasOne)) {
      $resource->hasOne = $hasOne;
    } else {
      $resource->hasOne[] = $hasOne;
    }
    $this->resources[$resourceType] = $resource;
    return $resource;
  }
  
  private function _accessProtected($obj, $prop) {
    $reflection = new \ReflectionClass($obj);
    if (!$reflection->hasProperty($prop) ) return null;
    $property = $reflection->getProperty($prop);
    $property->setAccessible(true);
    return $property->getValue($obj);
  }
  
  private function _accessProtectedFunction($obj, $prop) {
    $reflection = new \ReflectionClass($obj);
    if (!$reflection->hasMethod($prop) ) return null;
    $reflectionMethod = $reflection->getMethod($prop);
    $reflectionMethod->setAccessible(true);
    return $reflectionMethod->invoke($obj);
  }
  
  private function _getDocumentation($obj){
    $reflection = new \ReflectionClass($obj);
    $doc = $reflection->getDocComment() ?? "";
    $doc = preg_replace('/([\/]?[\s]*\*[\/]?)/iusx', '', $doc);
    return $doc;
  }
  
  private function _renameUnderscore($arr) {
    if( !is_array($arr) ) return $arr;
    foreach($arr as &$item) {
      $item = str_replace("_", "-", kebab_case($item) );
    }
    return $arr;
  }

}
