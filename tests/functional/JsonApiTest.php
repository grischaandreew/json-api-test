<?php
use \App\Debug\JsonDocApi;

/**
 * test the JsonApi resource endpoints and functions
 */

class JsonApiTest extends Base\Functional
{
    
    public function testV1Magazines()
    { 
        $this->_testResource("magazines");
    }
    
    public function testV1Sections()
    { 
        $this->_testResource("sections");
    }
    
    public function testV1Teasers()
    { 
        $this->_testResource("teasers");
    }
    
    public function testV1Articles()
    { 
        $this->_testResource("articles");
    }
    
    public function testV1Languages()
    { 
        $this->_testResource("languages");
    }
    
    public function testV1FuelLabels()
    { 
        $this->_testResource("fuel-labels");
    }
    
    public function testV1ContactPeople()
    { 
        $this->_testResource("contact-people");
    }
    
    public function testV1Media()
    { 
        $this->_testResource("media");
    }
    
    public function testV1FileTypes()
    { 
        $this->_testResource("file-types");
    }
    
    public function testV1FilterCategories()
    { 
        $this->_testResource("filter-categories");
    }
    
    public function testV1Copyrights()
    { 
        $this->_testResource("copyrights");
    }
    
    public function testV1SocialPosts()
    { 
        $this->_testResource("social-posts");
    }
    
    private function _testResource($resourceName){
      $jsonApi = new JsonDocApi();
      
      verify( "jsonApi description exists", isset($jsonApi->resources[$resourceName]) )->equals(true); 
      
      $resource = $jsonApi->resources[$resourceName];
      
      // test index page and check data structure
      $this->describe("validate $resource->name over JsonDocApi. GET /api/v1/$resource->name", function() use($resource){
        
        $test = $this->tester->get("/api/v1/$resource->name");
        verify( "GET response code is 200", $test->status() )->equals(200); 
        
        $content = json_decode($test->content(), true);
        
        verify( "data attribute exists", in_array('data', array_keys($content)) )->equals(true);
        
        $this->it("data value has only $resource->name", function() use($resource, $content) {
          foreach($content["data"] as $item){
            verify( "data.type is $resource->name", $item["type"] )->equals($resource->name);
            verify( "data.id exists", empty($item["id"]) )->equals(false);
            verify( "data.attributes exists", empty($item["attributes"]) )->equals(false);
            
            $keys = array_keys($item["attributes"]);
            
            foreach( $keys as $attributeName) {
              verify( "data.attribute $attributeName is configured", in_array($attributeName, $resource->attributes) )->equals(true);
            }
          }
        });
        
        // fetch first item
        $firstId = $content["data"][0]["id"];
        
        $this->refresh();
        
        $test = $this->tester->withHeaders([
          'Content-Type' => 'application/vnd.api+json',
          'Accept' => 'application/vnd.api+json'
        ])->get("/api/v1/$resource->name/$firstId");
        
        verify( "GET $resource->name first item, response code is 200 /api/v1/$resource->name/$firstId", $test->status() )->equals(200); 
        $content = json_decode($test->content(), true);
        verify( "GET $resource->name first item, data attribute exists", in_array('data', array_keys($content)) )->equals(true);
        
        $keys = array_keys($content["data"]["attributes"]);
        
        foreach( $keys as $attributeName) {
          verify( "GET $resource->name first item, data.attribute $attributeName is configured", in_array($attributeName, $resource->attributes) )->equals(true);
        }
        
        $firstItem = $content["data"]["attributes"];
        
        // test filter parameters
        $allowedFilteringParameters = $resource->allowedFilteringParameters ?? [];
        foreach($allowedFilteringParameters as $allowedFilteringParameter) {
          $search = $firstItem[$allowedFilteringParameter] ?? "lorem";
          if( is_array($search) ){
            $search = (string)array_pop($search);
          }
          $this->it("/api/v1/$resource->name?filter[$allowedFilteringParameter]=$search", function() use($resource, $firstItem, $allowedFilteringParameter, $search) {
            $this->refresh();
            $test = $this->tester->get("/api/v1/$resource->name?" . http_build_query([
              "filter[$allowedFilteringParameter]" => $search,
              "page[size]" => 1
            ]));
            verify( "GET response code is 200", $test->status() )->equals(200);
            $content = json_decode($test->content(), true);
            
            verify( "data attribute exists", in_array('data', array_keys($content)) )->equals(true);
          });
        }
        
        // test sort parameters
        $allowedSortParameters = $resource->allowedSortParameters ?? [];
        foreach($allowedSortParameters as $allowedSortParameter) {
          $this->it("/api/v1/$resource->name?sort=" . $allowedSortParameter, function() use($resource, $allowedSortParameter) {
            $this->refresh();
            $test = $this->tester->get("/api/v1/$resource->name?" . http_build_query([
              "sort" => $allowedSortParameter,
              "page[size]" => 1
            ]));
            verify( "GET response code is 200", $test->status() )->equals(200);
            $content = json_decode($test->content(), true);
            verify( "data attribute exists", in_array('data', array_keys($content)) )->equals(true);
          });
        }
        
        
        if (isset($firstItem["url-slug"])) {
          $this->it("load entity over url-slug /api/v1/$resource->name/" . $firstItem["url-slug"], function() use($resource, $firstItem) {
            $this->refresh();
            $test = $this->tester->get("/api/v1/$resource->name/" . $firstItem["url-slug"]);
            verify( "GET response code is 200", $test->status() )->equals(200);
            $content = json_decode($test->content(), true);
            verify( "data attribute exists", in_array('data', array_keys($content)) )->equals(true);
          });
        }
        
      });
    }
}