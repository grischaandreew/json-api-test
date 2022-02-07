<?php

/**
 * test Authorize middleware with different Request Methods and user profiles
 */
class AuthorizeTest extends Base\Functional
{
    
    public function testApiMiddlewareAtV1()
    {
      $this->describe("check api authorize header", function(){
        $this->it("/api/v1", function(){
          
          $test = $this->tester->json('GET', '/api/v1');
          verify( "GET response code is 200", $test->status() )->equals(200);
          
          $test = $this->tester->json('POST', '/api/v1');
          verify( "POST response code is 401", $test->status() )->equals(401);
          
          $test = $this->tester->json('PATCH', '/api/v1');
          verify( "PATCH response code is 401", $test->status() )->equals(401);
          
          $test = $this->tester->json('DELETE', '/api/v1');
          verify( "DELETE response code is 401", $test->status() )->equals(401);
        });
        
        $this->it("/api/v1 as user but no editor role (X-User-is-Editor=0)", function(){
          $headers = [
            'X-User-is-Editor' => '0',
            'X-User-Ciam-Uid' => '1234'
          ];
          
          $test = $this->tester->withHeaders($headers)->json('GET', '/api/v1');
          verify( "GET response code is 200", $test->status() )->equals(200);
          
          $test = $this->tester->withHeaders($headers)->json('POST', '/api/v1');
          verify( "POST response code is 401", $test->status() )->equals(401);
          $content = $test->content();
          verify( "error message \"User with ciam_uid ..\" is reported",
            str_contains( $content, "User with ciam_uid" )
          )->equals(true);
          
          $test = $this->tester->withHeaders($headers)->json('PATCH', '/api/v1');
          verify( "PATCH response code is 401", $test->status() )->equals(401);
          $content = $test->content();
          verify( "error message \"User with ciam_uid ..\" is reported",
            str_contains( $content, "User with ciam_uid" )
          )->equals(true);
          
          $test = $this->tester->withHeaders($headers)->json('DELETE', '/api/v1');
          verify( "DELETE response code is 401", $test->status() )->equals(401);
          $content = $test->content();
          verify( "error message \"User with ciam_uid ..\" is reported",
            str_contains( $content, "User with ciam_uid" )
          )->equals(true);
          
        });
        
        $this->it("/api/v1 as user but no editor role (X-User-is-Editor=undefined and X-User-Ciam-Uid)", function(){
          $headers = [
            'X-User-is-Editor' => '',
            'X-User-Ciam-Uid' => '12345'
          ];
          
          $test = $this->tester->withHeaders($headers)->json('GET', '/api/v1');
          verify( "GET response code is 401", $test->status() )->equals(200);
          
          $test = $this->tester->withHeaders($headers)->json('POST', '/api/v1');
          verify( "POST response code is 401", $test->status() )->equals(401);
          $content = $test->content();
          verify( "error message \"User with ciam_uid ..\" is reported",
            str_contains( $content, "User with ciam_uid" )
          )->equals(true);
          
          $test = $this->tester->withHeaders($headers)->json('PATCH', '/api/v1');
          verify( "PATH response code is 401", $test->status() )->equals(401);
          $content = $test->content();
          verify( "error message \"User with ciam_uid ..\" is reported",
            str_contains( $content, "User with ciam_uid" )
          )->equals(true);
          
          $test = $this->tester->withHeaders($headers)->json('DELETE', '/api/v1');
          verify( "DELETE response code is 401", $test->status() )->equals(401);
          $content = $test->content();
          verify( "error message \"User with ciam_uid ..\" is reported",
            str_contains( $content, "User with ciam_uid" )
          )->equals(true);
          
        });
        
        $this->it("/api/v1 as user but no editor role (X-User-is-Editor=1 and no X-Ciam-Uid)", function(){
          $headers = [
            'X-User-is-Editor' => '1',
            'X-User-Ciam-Uid' => ''
          ];
          
          $test = $this->tester->withHeaders($headers)->json('GET', '/api/v1');
          verify( "GET response code is 401", $test->status() )->equals(200);
          
          $test = $this->tester->withHeaders($headers)->json('POST', '/api/v1');
          verify( "POST response code is 401", $test->status() )->equals(401);
          $content = $test->content();
          verify( "error message \"User is not logged in.\" is reported",
            str_contains( $content, "User is not logged in." )
          )->equals(true);
          
          $test = $this->tester->withHeaders($headers)->json('PATCH', '/api/v1');
          verify( "PATCH response code is 401", $test->status() )->equals(401);
          $content = $test->content();
          verify( "error message \"User is not logged in.\" is reported",
            str_contains( $content, "User is not logged in." )
          )->equals(true);
          
          $test = $this->tester->withHeaders($headers)->json('DELETE', '/api/v1');
          verify( "DELETE response code is 401", $test->status() )->equals(401);
          $content = $test->content();
          verify( "error message \"User is not logged in.\" is reported",
            str_contains( $content, "User is not logged in." )
          )->equals(true);
          
        });
        
        $this->it("/api/v1 as user and editor role", function(){
          $headers = [
            'X-User-is-Editor' => '1',
            'X-User-Ciam-Uid' => '123456'
          ];
          
          $test = $this->tester->withHeaders($headers)->json('GET', '/api/v1');
          verify( "GET response code is 200", $test->status() )->equals(200);
          
          $test = $this->tester->withHeaders($headers)->json('POST', '/api/v1');
          $status = $test->status();
          verify( "http status is not 401", $status)->notEquals(401);
          
          $test = $this->tester->withHeaders($headers)->json('PATCH', '/api/v1');
          $status = $test->status();
          verify( "http status is not 401", $status)->notEquals(401);
          
          $test = $this->tester->withHeaders($headers)->json('DELETE', '/api/v1');
          $status = $test->status();
          verify( "http status is not 401", $status)->notEquals(401);
          
        });
        
      });
    }
}