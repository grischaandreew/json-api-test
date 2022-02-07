<?php
namespace Base;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Faker\Generator as FakerGenerator;

class Laravel extends TestCase
{
    private $_laravel;
    public function setLaravelModule($module){
      $this->_laravel = $module;
    }
    
    public function createApplication()
    {
        return $this->_laravel->getApplication();
    }
    
    #public function call($method, $uri,$parameters = [],$cookies = [],$files = [],$server = [], $content = null) {
    #  $resp = parent::call($method, $uri, $parameters, $cookies, $files, $server, $content );
    #  $this->refreshApplication();
    #  return $resp;
    #}
    
    /*protected function refreshApplication()
    {
        putenv('APP_ENV=testing');

        Facade::clearResolvedInstances();

        $this->app = $this->createApplication();
    }*/
    

    public function setUp()
    {
        parent::setUp();
        $this->createApplication();
    }
    
    public function getApplication(){
      return $this->_laravel->getApplication();
    }
    
    function getResponse(){
      return $this->response;
    }
}

