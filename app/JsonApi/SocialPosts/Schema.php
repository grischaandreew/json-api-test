<?php

namespace App\JsonApi\SocialPosts;

use App\Language;
use App\Media;
use App\SocialPost;
use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'social-posts';

    protected $attributes = [
      'origin-id',
      'origin-url',
      'title',
      'content', 
      'source',
      'publication-date'    
    ];

    public function getIncludePaths()
    {
      return [
        'language',
        'media'
      ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      if (!$resource instanceof SocialPost) {
        throw new RuntimeException('Expecting a SocialPost model.');
      }
      $language = $resource->language();
      $media = $resource->media();
      
      $data = [];
      if ( in_array('language', $includeRelationships) && $language){
        $data["language"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->language
        ];
      }
      if ( in_array('media', $includeRelationships) && $media->count() > 0){
        $data["media"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->media
        ];
      }
      return $data;
    }

}
