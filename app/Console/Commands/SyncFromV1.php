<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Ramsey\Uuid\Uuid;
use \App\Console\Commands\Migrations\V1toV2 as MigrationV1toV2;

/**
 * synchronize data from content api v1 to v2
 */

class SyncFromV1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:from:v1 {v1} {v2} {--debug} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Synchronize content from content-api-v1 to v2\nexample:\nsync:from:v1 https://api.media.mercedes-benz.com/v1/ http://127.0.0.1:8000/api/v1/";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      
      $config = [
        "from" => [
          'base_uri' => $this->argument('v1', 'https://api.media.mercedes-benz.com/v1/'),
          #'auth' => []
        ],
        "to" => [
          'base_uri' => $this->argument('v2', 'http://127.0.0.1:8000/api/v1/'),
          #'auth' => []
        ]
      ];
  
      $basicGuzzleParams = [
        'headers' => [
          'Content-Type' => 'application/vnd.api+json',
          'Accept' => 'application/vnd.api+json',
          'User-Agent' => null,
          'X-User-is-Editor' => '1',
          'X-User-Ciam-Uid'  => '1'
        ],
        'auth' => [],
        'http_errors' => false,
        'timeout' => 40*60,
        'debug' => $this->option('debug', false),
      ];
  
      $languages = ["de-DE", 'en-US'];
  
      foreach( $languages as $language ) {
        foreach( ['home'] as $magazine ) {
      
          $this->info("load magazines/$magazine/latest?lang=$language");
    
          $query = [
            'lang' => $language
          ];
    
          $clientV1 = new Client(array_merge($basicGuzzleParams, $config["from"], [
            'query' => $query
          ] ) );
      
          $clientV2 = new Client(array_merge($basicGuzzleParams, $config["to"], [
            'query' => $query
          ] ) );
    
          $apiUrl = "magazines/$magazine/latest";
          $response = $clientV1->request("GET", $apiUrl);
          $body = $response->getBody();
      
          $obj = json_decode( $body, true);
    
          $this->info("migrate magazines/$magazine/latest?lang=$language");
          $mig = new MigrationV1toV2($clientV1, $clientV2, $obj["data"], $obj["included"], $language);
    
          $this->info("start migration magazines/$magazine/latest?lang=$language");
    
          $new_data = $mig->migrate();
    
          $this->info("migration ended magazines/$magazine/latest?lang=$language");
      
        }
      }
  
      $articles = [];
      foreach( MigrationV1toV2::$_registry as $registryEntry ) {
        if ($registryEntry["type"] == "articles") {
          $articles[] = $registryEntry["original-id"]; 
        }
      }
      $this->info("migrate " . sizeof($articles) . " articles");
      foreach( $articles as $articleId ) {
        foreach( $languages as $language ) {
          $this->info("load articles/$articleId?lang=$language");
      
          $query = [
            'lang' => $language
          ];
      
          $clientV1 = new Client(array_merge($basicGuzzleParams, $config["from"], [
            'query' => $query
          ] ) );
      
          $clientV2 = new Client(array_merge($basicGuzzleParams, $config["to"], [
            'query' => $query
          ] ) );
      
          $apiUrl = "articles/$articleId";
          $response = $clientV1->request("GET", $apiUrl);
          $body = $response->getBody();
      
          $obj = json_decode( $body, true);
      
          $this->info("migrate articles/$articleId?lang=$language");
          $mig = new MigrationV1toV2($clientV1, $clientV2, $obj["data"], $obj["included"], $language);
      
          $this->info("start migration articles/$articleId?lang=$language");
      
          $new_data = $mig->migrate();
      
          $this->info("migration ended articles/$articleId?lang=$language");
        }
      }
    }
}
