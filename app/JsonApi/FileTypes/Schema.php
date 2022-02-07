<?php

namespace App\JsonApi\FileTypes;


use App\Media;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'file-types';

    protected $attributes = [
      'name',
      'mime_types',
      'file_extensions',
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
