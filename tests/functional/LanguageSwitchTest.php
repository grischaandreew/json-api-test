<?php

/**
 * test the language middleware
 */

class LanguageSwitchTest extends Base\Functional
{
   
    public function testApiV1Middleware()
    {
      
      $this->describe("check language config", function(){
        $this->it("/api/v1", function(){
          $app = $this->tester->getApplication();
          
          verify( "app.getLocale and config.translatable.locale are same",
            $app->getLocale()
          )->equals( config('translatable.locale') );
          
          $language = "DE-de";
          $test = $this->tester->json('GET', '/api/v1/magazines', [
            "lang" => $language
          ]);
          
          verify( "after request with specific lang app.getLocale and config.translatable.locale are same",
            $app->getLocale()
          )->equals( config('translatable.locale') );
          verify( "after request with specific lang app.getLocale and config.translatable.locale has new value",
            $app->getLocale()
          )->equals( $language );
            
          $language = "HANS-zh";
          $test = $this->tester->json('GET', '/api/v1/magazines', [
            "lang" => $language
          ]);
          
          verify( "after request with specific lang app.getLocale and config.translatable.locale are same",
            $app->getLocale()
          )->equals( config('translatable.locale') );
          verify( "after request with specific lang app.getLocale and config.translatable.locale has new value",
            $app->getLocale()
          )->equals( $language );
          
        });
        
      });
    }
}