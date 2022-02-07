<?php
use Barryvdh\Debugbar\Facade as Debugbar;

/**
 * test JsonApiDocumentation HTML and Swagger pages
 * test the debug middleware
 */

class DebugTest extends Base\Functional
{
   
    public function testApiV1DebugHandler()
    {
      $this->describe("check api description routes", function(){
        $this->it("/api/v1", function(){
          
          $test = $this->tester->call('GET', '/api/v1');
          verify( "GET response code is 200", $test->status() )->equals(200);
          
          $content = $test->content();
          verify( "is html",
            str_contains( $content, "<html" )
          )->equals(true);
            
          verify( "title is there",
            str_contains( $content, "<title>memedia EditorialApp JSON.org Api</title>" )
          )->equals(true);
            
          verify( "table is there",
            str_contains( $content, "<table" )
          )->equals(true);
          
          verify( "resource magazines is described",
            str_contains( $content, "/api/v1/magazines" )
          )->equals(true);
            
          verify( "resource sections is described",
            str_contains( $content, "/api/v1/sections" )
          )->equals(true);
          
          verify( "resource teasers is described",
            str_contains( $content, "/api/v1/teasers" )
          )->equals(true);
          
          verify( "resource articles is described",
            str_contains( $content, "/api/v1/articles" )
          )->equals(true);
          
          verify( "resource fuel-labels is described",
            str_contains( $content, "/api/v1/fuel-labels" )
          )->equals(true);
          
          verify( "resource contact-people is described",
            str_contains( $content, "/api/v1/contact-people" )
          )->equals(true);
          
          verify( "resource media is described",
            str_contains( $content, "/api/v1/media" )
          )->equals(true);
          
          verify( "resource file-types is described",
            str_contains( $content, "/api/v1/file-types" )
          )->equals(true);
                
          verify( "resource filter-categories is described",
            str_contains( $content, "/api/v1/filter-categories" )
          )->equals(true);
                  
          verify( "resource copyrights is described",
            str_contains( $content, "/api/v1/copyrights" )
          )->equals(true);
          
          verify( "resource social-posts is described",
            str_contains( $content, "/api/v1/social-posts" )
          )->equals(true);
        });
        
      });
    }
    
    public function testDebugMiddleware()
    {
      $this->describe("check working of debug GET parameter", function(){
        $this->it("/api/v1?debug=1", function(){
          $test = $this->tester->call('GET', '/api/v1?debug=1');
          verify( "GET response code is 200", $test->status() )->equals(200);
          
          $content = $test->content();
          verify( "_debugbar assets stylesheets is loaded",
            str_contains( $content, "/_debugbar/assets/stylesheets" )
          )->equals(true);
            
          verify( "_debugbar assets javascript is loaded",
            str_contains( $content, "/_debugbar/assets/javascript" )
          )->equals(true);
        });
        
        $this->refresh();
        
        $this->it("/api/v1 rendering without debugging", function(){
          $test = $this->tester->call('GET', '/api/v1');
          verify( "GET response code is 200", $test->status() )->equals(200);
          
          $content = $test->content();
          verify( "_debugbar assets stylesheets is loaded",
            str_contains( $content, "/_debugbar/assets/stylesheets" )
          )->equals(false);
            
          verify( "_debugbar assets javascript is loaded",
            str_contains( $content, "/_debugbar/assets/javascript" )
          )->equals(false);
        });
        
        $this->refresh();
        
        $this->it("/_debugbar/assets/stylesheets", function(){
          $test = $this->tester->call('GET', '/_debugbar/assets/stylesheets');
          verify( "GET response code is 200", $test->status() )->equals(200);
        });
        
        $this->refresh();
        
        $this->it("/_debugbar/assets/javascript", function(){
          $test = $this->tester->call('GET', '/_debugbar/assets/javascript');
          verify( "GET response code is 200", $test->status() )->equals(200);
        });
      });
      
      Debugbar::disable();
    }
    
    public function testSwaggerDocument()
    {
      $this->describe("check http generator for swagger document", function(){
        $this->it("/api/v1.yaml", function(){
          $test = $this->tester->call('GET', '/api/v1.yaml');
          verify( "GET response code is 200", $test->status() )->equals(200);
          
          $content = $test->content();
          verify( "response is not a html page",
            str_contains( $content, "<html" )
          )->equals(false);
            
          verify( "response has 'swagger:'",
            str_contains( $content, "swagger:" )
          )->equals(true);
        });
      });
      $this->describe("check console command for swagger document", function(){
        $swaggerFilePath = base_path('docs/api/swagger.yaml');
        @unlink($swaggerFilePath);
        $this->tester->artisan("update:swagger");
        verify( "ensure that docs/api/swagger.yaml exists", file_exists($swaggerFilePath) )->equals(true);
      });
    }
}