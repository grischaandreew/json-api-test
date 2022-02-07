<?php

namespace App\JsonApi\FilterCategories;


use App\FilterCategory;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'filter-categories';

    protected $attributes = [
      'name',
      'publication_date'    
    ];

    public function getIncludePaths()
    {
      return [
        
      ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      return [];
    }

}
