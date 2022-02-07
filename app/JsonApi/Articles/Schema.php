<?php

namespace App\JsonApi\Articles;


use App\Article;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;


class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'articles';

    protected $attributes = [
      'origin-id',
      'url-slug',
      'display-date', 'read-count', 'download-count', 'share-count',
      'title', 'seo-title', 'topic', 'excerpt',
      'content', 'formatted-content', 'location',
      'source',
      'og-title', 'og-image', 'og-description',
      'localised-read-count', 'localised-download-count', 'localised-share-count',
      'publication-date'
    ];
    
    protected $attributesIncluded = [
      'origin-id',
      'url-slug',
      'title',
      'topic',
      'excerpt',
      'location',
      'source',
      'read-count',
      'download-count',
      'share-count',
      'localised-read-count', 'localised-download-count', 'localised-share-count',
      'publication-date',
      'display-date'
    ];

    public function getIncludePaths()
    {
      return [
        "audios",
        "contact-people",
        "documents",
        "fuel-labels",
        "images",
        "videos",
        "sections"
      ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      if (!$resource instanceof Article) {
        throw new RuntimeException('Expecting a Article model.');
      }
      $audios           = $resource->audios();
      $contactPersons   = $resource->contactPersons();
      $documents        = $resource->documents();
      $labels           = $resource->fuelLabels();
      $images           = $resource->images();
      $videos           = $resource->videos();
      $sections         = $resource->sections();
      
      $data = [];
      
      if ( in_array("audios", $includeRelationships) && $audios->count() > 0){
        $data["audios"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->audios
        ];
      }
      if ( in_array("contact-people", $includeRelationships) && $contactPersons->count() > 0){
        $data["contact-people"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->contactPersons
        ];
      }
      if ( in_array("documents", $includeRelationships) && $documents->count() > 0){
        $data["documents"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->documents
        ];
      }
      
      if ( in_array("fuel-labels", $includeRelationships) && $labels->count() > 0){
        $data["fuel-labels"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->fuelLabels
        ];
      }
      if ( in_array("images", $includeRelationships) && $images->count() > 0){
        $data["images"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->images
        ];
      }
      if ( in_array("videos", $includeRelationships) && $videos->count() > 0){
        $data["videos"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->videos
        ];
      }
      if ( in_array("sections", $includeRelationships) && $sections->count() > 0){
        $data["sections"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->sections
        ];
      }
      return $data;
    }
    

}
