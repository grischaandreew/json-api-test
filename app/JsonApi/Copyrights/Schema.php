<?php

namespace App\JsonApi\Copyrights;


use App\Copyright;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'copyrights';

    protected $attributes = [
      'description',
      'owner',
      'year',
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
