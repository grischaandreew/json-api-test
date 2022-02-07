<?php

namespace App\JsonApi\Magazines;


use App\Magazine;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'magazines';

    protected $attributes = [
      'identifier',
      'url_slug',
      'publication_date'  
    ];

    public function getIncludePaths()
    {
      return [
        "sections",
        "sections.teasers",
        "sections.teasers.media",
        "sections.teasers.media.fuel-labels",
        "sections.teasers.images",
        "sections.teasers.images.fuel-labels",
        "sections.teasers.videos",
        "sections.teasers.videos.fuel-labels",
        "sections.teasers.fuel-labels",
        "sections.teasers.articles",
        "sections.teasers.articles.fuel-labels"
      ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      if (!$resource instanceof Magazine) {
        throw new RuntimeException('Expecting a Magazine model.');
      }
      $sections = $resource->sections();
      $data = [];
      if ( in_array('sections', $includeRelationships) &&  $sections->count() > 0){
        $data["sections"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->sections
        ];
      }
      return $data;
    }

}
