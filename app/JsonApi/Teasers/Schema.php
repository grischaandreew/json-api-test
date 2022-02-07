<?php

namespace App\JsonApi\Teasers;


use App\Teaser;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'teasers';

    protected $attributes = [
      'title',
      'publication-date'    
    ];
    
    protected $attributesIncluded = [
      'title',
      'publication-date'
    ];

    public function getIncludePaths()
    {
      return [
        'article',
        'fuel-labels',
        'images',
        'videos'
      ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      if (!$resource instanceof Teaser) {
        throw new RuntimeException('Expecting a Teaser model.');
      }
      
      $labels = $resource->fuelLabels();
      $images = $resource->images();
      $videos = $resource->videos();
      
      $data = [];
      
      if( in_array('article', $includeRelationships) ) {
        $article = $resource->article();
        if ($article){
          $data["article"] = [
            self::SHOW_SELF => true,
            self::SHOW_RELATED => false,
            self::DATA => function () use ($resource) { return $resource->article; }
          ];
        }
      }
      
      if ( in_array('fuel-labels', $includeRelationships) && $labels->count() > 0){
        $data["fuel-labels"] = [
          self::SHOW_SELF => false,
          self::SHOW_RELATED => false,
          self::DATA => function () use ($resource) { return $resource->fuelLabels; }
        ];
      }
      
      if ( ( in_array('images', $includeRelationships) || in_array('media', $includeRelationships) ) && $images->count() > 0){
        $data["images"] = [
          self::SHOW_SELF => false,
          self::SHOW_RELATED => false,
          self::DATA => function () use ($resource) { return $resource->images; }
        ];
      }
      if ( (in_array('videos', $includeRelationships) || in_array('media', $includeRelationships) ) && $videos->count() > 0){
        $data["videos"] = [
          self::SHOW_SELF => false,
          self::SHOW_RELATED => false,
          self::DATA => function () use ($resource) { return $resource->videos; }
        ];
      }
      return $data;
    }

}
