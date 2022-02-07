<?php

namespace App\JsonApi;

use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;

class BaseValidator extends AbstractValidatorProvider
{

    protected $allowUnrecognizedParameters = true;
    
    /**
     * @var array
     */
    protected $allowedSortParameters = [
        
    ];

    protected function attributeRules($record = null)
    {
      return [];
    }
    
    /**
     * @inheritDoc
     */
    protected function relationshipRules(RelationshipsValidatorInterface $relationships, $record = null)
    {
        // no-op
    }

}
