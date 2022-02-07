<?php
namespace App\JsonApi\Languages;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'languages';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
        'id',
        'is-default'
    ];

    protected $allowedIncludePaths = [
      
    ];
    
    protected $queryRules = [
      'filter.language-name' => 'string|min:1',
      'filter.country-name' => 'string|min:1',
      'filter.iso-language' => 'string|min:1',
      'filter.iso-country' => 'string|min:1',
      'filter.is-default' => 'string|min:1',
      'page.number' => 'integer|min:1',
      'page.size' => 'integer|between:1,50',
    ];
    
    /**
     * @var array
     */
    protected $allowedSortParameters = [
        'updated-at',
        'publication-date',
        'language-name'
    ];

    protected function attributeRules($record = null)
    {
        return [
            'language-name' => "nullable|string|between:1,255",
            'country-name' => "nullable|string|between:1,255",
            'iso-language' => "nullable|string|between:1,2",
            'iso-country' => "nullable|string|between:1,2", 
            'isDefault' => "boolean",
            'publication-date' => "nullable|date" 
        ];
    }

}
