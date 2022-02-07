<?php
namespace App\JsonApi\Copyrights;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;


class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'copyrights';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'id',
      'description',
      'owner',
      'year'
    ];

    protected $allowedIncludePaths = [
      
    ];
    
    protected $queryRules = [
      'filter.description' => 'string|min:1',
      'filter.owner' => 'string|min:1',
      'filter.year' => 'integer',
      'page.number' => 'integer|min:1',
      'page.size' => 'integer|between:1,50',
    ];
    
    /**
     * @var array
     */
    protected $allowedSortParameters = [
        'updated-at',
        'publication-date',
        'year'
    ];

    protected function attributeRules($record = null)
    {
        return [
          'description' => "nullable|string",
          'year' => "nullable|integer",
          'owner' => "nullable|string|between:1,255",
          'publication-date' => "nullable|date",
        ];
    }
}
