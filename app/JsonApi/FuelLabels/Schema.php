<?php

namespace App\JsonApi\FuelLabels;


use App\FuelLabel;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'fuel-labels';

    protected $attributes = [
      'text',
      'publication-date'
    ];
    
    protected $attributesIncluded = [
      'text'
    ];

    public function getIncludePaths()
    {
      return [];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      if (!$resource instanceof FuelLabel) {
        throw new RuntimeException('Expecting a FuelLabel model.');
      }
      $data = [];
      
      return $data;
    }

}
