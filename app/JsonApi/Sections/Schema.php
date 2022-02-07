<?php

namespace App\JsonApi\Sections;


use App\Section;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'sections';

    protected $attributes = [
      'title',
      'section-headlines',
      'section-type',
      'publication-date'
    ];
    
    protected $attributesIncluded = [
      'title',
      'section-headlines',
      'section-type'
    ];

    public function getIncludePaths()
    {
      return [
        'teasers'
      ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      if (!$resource instanceof Section) {
        throw new RuntimeException('Expecting a Section model.');
      }
      $teasers = $resource->teasers();
      $data = [];
      if ( in_array('teasers', $includeRelationships) && $teasers->count() > 0){
        $data["teasers"] = [
          self::SHOW_SELF => false,
          self::SHOW_RELATED => false,
          self::DATA => function () use ($resource) { return $resource->teasers; }
        ];
      }
      return $data;
    }

}
