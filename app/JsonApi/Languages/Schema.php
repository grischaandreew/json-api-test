<?php

namespace App\JsonApi\Languages;

use App\Toc;
use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'languages';

    protected $attributes = [
        'language_name',
        'country_name',
        'iso_language',
        'iso_country', 
        'isDefault',
        'publication_date'     
    ];

    public function getIncludePaths()
    {
      return [];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      return [];
    }


}
