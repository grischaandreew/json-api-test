<?php
namespace App\JsonApi\FilterCategories;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'filter-categories';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'id',
      'name'
    ];

    protected $allowedIncludePaths = [
      
    ];
    
    protected $queryRules = [
      'filter.name' => 'string|min:1',
      'page.number' => 'integer|min:1',
      'page.size' => 'integer|between:1,50',
    ];
    
    /**
     * @var array
     */
    protected $allowedSortParameters = [
        'updated-at',
        'publication-date'
    ];

    protected function attributeRules($record = null)
    {
        return [
          'name' => "nullable|string|between:1,255",
          'publication-date' => "nullable|date",
        ];
    }

}
