<?php
namespace App\Console\Commands\Migrations;

#use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Ramsey\Uuid\Uuid;

if(class_exists('V1toV2')) return;

class V1toV2 {
  
  static $_registry = [];
  
  function __construct($clientV1, $clientV2, $data, $included, $language){
    $this->_included = $included;
    $this->_data = $data;
    $this->_clientV1 = $clientV1;
    $this->_clientV2 = $clientV2;
    $this->language = $language;
  }
  
  function migrate(){
    $this->_loadregistry();
    $migrated = $this->_transformObject($this->_data);
    $this->_saveregistry();
    return [
      "data" => $migrated
    ];
  }
  
  function _createResource($data){
    
    $originalId = $data["id"];
    
    if (isset($data["relationships"]) && is_array($data["relationships"])) {
      foreach($data["relationships"] as $relation_key => $relation_data ){
        if(empty($relation_data)) {
          unset($data["relationships"][$relation_key]);
        }
        if(empty($relation_data["data"])) {
          unset($data["relationships"][$relation_key]);
        }
      }
    }
    if( empty($data["relationships"]) ) {
      unset($data["relationships"]);
    }
    
    $ids = (array) (isset($data["_ids"]) ? $data["_ids"] : $data["id"]);
    if(isset($data["_ids"])) {
      unset($data["_ids"]);
    }
    $existsID = null;
    if (isset(self::$_registry[$originalId])) {
      $existsID = self::$_registry[$originalId]["id"];
    }
    
    if (is_null($existsID)) {
      foreach( $ids as $id ) {
        $response = $this->_clientV2->get($data["type"] . "/" . $id);
        $status = $response->getStatusCode();
        if ($response->getStatusCode() == 200){
          $body = $response->getBody()->getContents();
          $response = json_decode($body, true);
          if( isset($response["data"]["id"]) ) {
            $existsID = $response["data"]["id"];
            break;
          }
        }
      }
    }
    
    if ($existsID) {
      $data["id"] = $existsID;
    }
    if(isset($data["relationships"]["article"])) {
      #$data["attributes"]["article_id"] = $data["relationships"]["article"]["data"][0]["id"];
      $data["relationships"]["article"]["data"] = $data["relationships"]["article"]["data"][0];
    }
    
    $data["attributes"]["id"] = $data["id"];
    
    $params = [
      'body' => json_encode([
        "data" => $data
      ])
    ];
    
    if ($existsID) {
      $apiUrl = $data["type"] . "/" . $existsID;
      $response = $this->_clientV2->patch($apiUrl, $params);
    } else {
      $apiUrl = $data["type"];
      $response = $this->_clientV2->post($apiUrl, $params);
    }
    
    $body = $response->getBody()->getContents();
    
    $response = json_decode($body, true);
    
    if( !isset($response["data"]["type"]) || !isset($response["data"]["id"]) ) {
      print substr($body, 0, 1512);
      print_r($data);
      
    } else {
      $this->_addregistry($originalId, $response["data"]["type"], $response["data"]["id"]);
      return [
        "type" => $response["data"]["type"],
        "id"   => $response["data"]["id"]
      ];
    }
    
    print "\n\n";
    $this->_saveregistry();
    exit();
  }
  
  function _addregistry($originalId, $type, $newId){
    self::$_registry[$originalId] = [
      "original-id" => $originalId,
      "type" => $type,
      "id"   => $newId
    ];
  }
  
  function _getCachedKey(){
    if( !$this->_clientV1 || !$this->_clientV2 ) {
      return;
    }      
    return md5($this->_clientV1->getConfig('base_uri') . "_" . $this->_clientV2->getConfig('base_uri'));
  }
  
  function _loadregistry(){
    $cachedKey = $this->_getCachedKey();
    if (!$cachedKey) {
      return;
    }
    $registry = @unserialize(
      @file_get_contents(
        storage_path('app/migration-registry-'.$cachedKey.'.serialize')
      )
    );
    if (is_array($registry)) {
      self::$_registry = $registry;
    }
  }
  
  function _saveregistry(){
    $cachedKey = $this->_getCachedKey();
    if (!$cachedKey) {
      return;
    }
    file_put_contents(
      storage_path('app/migration-registry-'.$cachedKey.'.serialize'),
      serialize(self::$_registry)
    );
  }
  
  function _findIncluded($type, $id){
    foreach( $this->_included as $included ) {
      if ($included["type"] == $type && $included["id"] == $id){
        return $included;
      }
    }
    return null;
  }
  
  function _transformObject($data){
    $type = $data["type"];
    if( !method_exists($this, $type) ) {
      throw new Exception("type $type has no migration");
    }
    
    $before_relationships = [];
    if (isset($data["relationships"])) {
      foreach( $data["relationships"] as $key => $rdata){
        if( !empty($rdata["data"]) && !empty($rdata["data"][0]["id"]) ) {
          $before_relationships[] = $key;
        }
      };
    }
    
    
    $ndata = $this->{$type}($data);
    if (isset($ndata["relationships"])) {
      foreach( $ndata["relationships"] as $key => $relationship ) {
        if( !isset($relationship["data"]) ) continue;
        $entries = [];
        foreach( $relationship["data"] as $relationshipEntry) {
          if( !isset($relationshipEntry["type"]) ) {
            continue;
          }
          $entry = $this->_findIncluded($relationshipEntry["type"], $relationshipEntry["id"]);
          if ($entry) {
            $entry = $this->_transformObject($entry);
            $entries[] = $entry;
          }
        }
        $ndata["relationships"][$key] = [ "data" => $entries ];
      }
    }
    
    $after_relationships = array_keys($ndata["relationships"] ?? []);
    
    if( in_array("article", $after_relationships) ) {
      $after_relationships[] = "articles";
    }
    if( in_array("media", $after_relationships) ) {
      $after_relationships[] = "teaserimagestacks";
      $after_relationships[] = "images";
    }
    if( in_array("fuel-labels", $after_relationships) ) {
      $after_relationships[] = "labels";
    }
    if( in_array("teasers", $after_relationships) ) {
      $after_relationships[] = "teaserimagestacks";
      $after_relationships[] = "imagestacks";
      $after_relationships[] = "contactPersons";
    }
      
    $nr = [];
    foreach($before_relationships as $rel){
      if( !in_array($rel, $after_relationships) ) {
        $nr[] = $rel;
      }
    }
    if(sizeof($nr)) {
      print "\n---- $type relations\n";
      print "\t" . join("\n\t", $nr);
      print "\n---\n";
      print "\t" . join("\n\t", array_keys($ndata["relationships"] ?? []) );
      print "\n----";
      #$this->_saveregistry();
      #exit();
    }
    #if( method_exists($this, $type."After") ) {
    #  $ndata = $this->{$type."After"}($ndata);
    #}
    
    $rdata = $this->_createResource($ndata);
    return $rdata;
  }
  
  function _toDate($DateStr)
  {
    return date("Y-m-d H:i:s", strtotime($DateStr));
  }
  
  function magazine($data){
    $attr = $data["attributes"];
    $descs = explode("_", $attr["description"]);
    $origin_id = $descs[0];
    return [
      'id' => $data["id"],
      '_ids' => [ $origin_id ],
      'type' => 'magazines',
      'attributes' => [
        'identifier' => $origin_id,
        'url_slug' => $origin_id
      ],
      'relationships' => [
        'sections' => $data["relationships"]["sections"]
      ]
    ];
  }
  
  function section($data){
    
    #$sectionTypeTranslations = [
    #  ''
    #];
    
    return [
      'id' => $data["id"],
      'type' => 'sections',
      'attributes' => [
        'section_type' => $sectionTypeTranslations[$data["attributes"]["sectionType"]] ?? $data["attributes"]["sectionType"],
        'title' => $data["attributes"]["title"] ?? "",
        # section_headlines => ?
        # publication_date => ?
      ],
      'relationships' => [
        'teasers' => array_merge(
          $data["relationships"]["teasers"] ?? [],
          $data["relationships"]["videostacks"] ?? [],
          $this->_toTeaser( "media", $data["relationships"]["documents"] ?? [] ),
          $data["relationships"]["imagestacks"] ?? [],
          $this->_toTeaser( "contactPersons", $data["relationships"]["contactPersons"] ?? [] ),
          $data["relationships"]["labels"] ?? []
        )
      ]
    ];
  }
  
  function _findUniqueImages($data){
    $shelfNumbers = [];
    foreach($data as &$item){
      $item = $this->_findIncluded($item["type"], $item["id"]);
      if($item){
        $shelfNumbers[$item["attributes"]["shelfNumber"]][$item["attributes"]["filesize"]] = $item;
      }
    }
    $returns = [];
    foreach($shelfNumbers as $shelfNumber => $images){
      ksort($images, SORT_NUMERIC);
      #$ratios = [];
      
      $image = array_pop($images);
       
      $returns[] = [
        "type" => $image["type"],
        "id"   => $image["id"]
      ];
    }
    return $returns;
  }
  
  function teaser($data){
    $images = [];
    foreach( $data["relationships"]["teaserimagestacks"]["data"] as $imagestack ) {
      $imagestack = $this->_findIncluded($imagestack["type"], $imagestack["id"]);
      $images = array_merge($images, $imagestack["relationships"]["images"]["data"]);
    }
    $images = $this->_findUniqueImages($images);
    
    if( isset($data["relationships"]["imagestacks"]["data"]) ) {
      var_dump($data["relationships"]);
      $this->_saveregistry();
      exit();
    }
    if( isset($data["relationships"]["videostacks"]["data"]) ) {
      var_dump($data["relationships"]);
      $this->_saveregistry();
      exit();
    }
    
    return [
      'id' => $data["id"],
      'type' => 'teasers',
      'attributes' => [
        'title' => $data["attributes"]["title"],
        'publication_date' => $this->_toDate($data["attributes"]["displayDate"]),
      ],
      'relationships' => [
        'article' => $data["relationships"]["articles"],
        'fuel-labels' => $data["relationships"]["labels"] ?? [],
        'contact-people' => $data["relationships"]["contactPersons"] ?? [],
        'media' => [
          "data" => array_merge(
            $images,
            $data["relationships"]["documents"] ?? []
          )
        ]
      ]
    ];
  }
  
  function _toTeaser($type, $data){
    if (!sizeof($data)) {
      return $data;
    }
    return [
      'id' => (string)Uuid::uuid4(),
      'type' => 'teasers',
      'attributes' => [
        'title' => "",
      ],
      'relationships' => [
        $type => $data
      ]
    ];
  }
  
  function imagestack($data){
    $images = $data["relationships"]["images"]["data"];
    $images = $this->_findUniqueImages($images);
    return [
      'id' => $data["id"],
      'type' => 'teasers',
      'attributes' => [
        'title' => $data["attributes"]["title"] ?? "",
        #'publication_date' => $this->_toDate($data["attributes"]["displayDate"]),
      ],
      'relationships' => [
        #'article' => $data["relationships"]["articles"],
        #'fuel-labels' => $data["relationships"]["labels"] ?? [],
        #'contact-people' => $data["relationships"]["contactPersons"] ?? [],
        'media' => [
          "data" => $images
        ]
      ]
    ];
  }
  
  function videostack($data){
    $videos = $data["relationships"]["videos"]["data"];
    return [
      'id' => $data["id"],
      'type' => 'teasers',
      'attributes' => [
        'title' => $data["attributes"]["title"] ?? "",
      ],
      'relationships' => [
        'media' => [
          "data" => $videos
        ]
      ]
    ];
  }
  
  function article($data){
    $attr = $data["attributes"];
    return [
      'id' => $data["id"],
      'type' => 'articles',
      '_ids' => [ $attr["originId"] ],
      'attributes' => [
        'origin-id'  => $attr["originId"],
        #'url_slug',
        'publication-date' => $this->_toDate($attr["publishedAt"]),
        'display-date' => $this->_toDate($attr["displayDate"]),
        'title' => $attr["title"],
        'seo-title' => $attr["seo"]["pageTitle"],
        'topic' => $attr["topic"],
        'excerpt' => "",
        'content' => $attr["content"],
        'formatted-content' => $attr["formattedContent"],
        'location' => $attr["location"],
        'source' => $attr["source"],
        #'read_count',
        #'download_count',
        #'share_count'
      ],
      'relationships' => array_merge([
        'contact-people' => $data["relationships"]["contactPersons"] ?? []
      ], $data["relationships"] ?? [] )
    ];
  }
  
  function image($data){
    $attr = $data["attributes"];
    if( isset($attr["caption"]) && $attr["title"] == $attr["caption"] ) {
      unset($attr["caption"]);
    }
    return [
      'id' => $data["id"],
      'type' => 'media',
      'attributes' => [
        'title' => $attr["title"],
        'caption' => $attr["caption"] ?? null,
        #'description',
        #'transcription',
        #'page_count',
        #'filename' => $attr["location"],
        'filesize' => $attr["filesize"],
        'width' => $attr["resolution"]["height"],
        'height' => $attr["resolution"]["width"],
        'mars-shelf-number' => $attr["shelfNumber"],
        'ratios' => isset($attr['aspectRatio']) ? [ $attr['aspectRatio'] ] : [],
        #'duration',
        #'publishing_id',
        'media-type' => "image",
        'content-language' => $this->language
        #'publication_date'
      ]
    ];
  }
  
  function video($data){
    $attr = $data["attributes"];
    if( isset($attr["caption"]) && $attr["title"] == $attr["caption"] ) {
      unset($attr["caption"]);
    }
    return [
      'id' => $data["id"],
      'type' => 'media',
      'attributes' => [
        'title' => $attr["title"],
        'caption' => $attr["caption"] ?? null,
        'description' => $attr["previewLocation"] ?? null,// ??
        #'transcription',
        #'page_count',
        #'filename' => $attr["location"],
        'filesize' => $attr["filesize"] ?? "0",
        'width' => $attr["resolution"]["height"] ?? "0",
        'height' => $attr["resolution"]["width"] ?? "0",
        'mars-shelf-number' => $attr["originId"],
        #'duration',
        #'publishing_id',
        'media-type' => "video",
        'content-language' => $this->language
        #'publication_date'
      ]
    ];
  }
  
  function label($data){
    $attr = $data["attributes"];
    return [
      'id' => $data["id"],
      'type' => 'fuel-labels',
      'attributes' => [
        'text' => $attr["text"],
        #'publication_date'
      ]
    ];
  }
  
  
  function contactPerson($data){
    $attr = $data["attributes"];
    return [
      'id' => $data["id"],
      'type' => 'contact-people',
      'attributes' => [
        'firstname' => $attr["firstname"] ?? "",
        'lastname' => $attr["lastname"] ?? "",
        'title' => $attr["title"] ?? "",
        'position' => $attr["position"] ?? "",
        'email' => $attr["email"] ?? "",
        'phone' => $attr["phone"] ?? "",
        'mobile' => $attr["mobile"] ?? ""
        #'fax' => 
        #'publication_date'
      ]
    ];
  }
  
  function document($data){
    $attr = $data["attributes"];
    return [
      'id' => $data["id"],
      'type' => 'media',
      'attributes' => [
        'title' => $attr["title"],
        'caption' => $attr["caption"] ?? null,
        'description' => $attr["filename"] ?? null,
        #'transcription',
        'page-count' => $attr["pages"] ?? "",
        'filesize' => $attr["filesize"] ?? "",
        'width' => $attr["resolution"]["height"] ?? "0",
        'height' => $attr["resolution"]["width"] ?? "0",
        'mars-shelf-number' => $attr["shelfNumber"] ?? ($attr["originId"] ?? ""),
        #'duration',
        #'publishing_id',
        'media-type' => "document",
        'content-language' => $this->language
        #'publication_date'
      ]
    ];
  }
}