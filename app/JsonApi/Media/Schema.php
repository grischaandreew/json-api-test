<?php

namespace App\JsonApi\Media;


use App\Media;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'media';

    protected $attributes = [
      'publishing-id',
      'media-type',
      'publication-date',
      'storage-uuid',
      'filesize',
      'page-count',
      'width',
      'height',
      'ratios',
      'duration',
      'mars-publish-id',
      'mars-shelf-number',
      'mars-archive-number',
      'title',
      'caption',
      'description',
      'og-title',
      'og-image',
      'og-description',
      'content-language'
    ];
    
    protected $attributesIncluded = [
      #'publishing-id',
      'media-type',
      'publication-date',
      'storage-uuid',
      'filesize',
      'page-count',
      'width',
      'height',
      'ratios',
      'duration',
      #'mars-publish-id',
      #'mars-shelf-number',
      #'mars-archive-number',
      'title',
      'caption',
      'description',
      'content-language'
      #'og-title',
      #'og-image',
      #'og-description' 
    ];

    public function getIncludePaths()
    {
      return [
        "file-type",
        "filter-categories",
        "copyrights",
        "fuel-labels"
      ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      if (!$resource instanceof Media) {
        throw new RuntimeException('Expecting a Media model.');
      }
      $fileType         = $resource->fileType();
      $filterCategories = $resource->filterCategories();
      $copyrights       = $resource->copyrights();
      $fuelLabels       = $resource->fuelLabels();
      
      $data = [];
      if ( in_array('file-type', $includeRelationships) && $fileType){
        $data["file-type"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->fileType
        ];
      }
      if ( in_array('filter-categories', $includeRelationships) && $filterCategories->count() > 0){
        $data["filter-categories"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->filterCategories
        ];
      }
      if ( in_array('copyrights', $includeRelationships) && $copyrights->count() > 0){
        $data["copyrights"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->copyrights
        ];
      }
      if ( in_array('fuel-labels', $includeRelationships) && $fuelLabels->count() > 0){
        $data["fuel-labels"] = [
          self::SHOW_SELF => true,
          self::SHOW_RELATED => false,
          self::DATA => $resource->fuelLabels
        ];
      }
      return $data;
    }

}
