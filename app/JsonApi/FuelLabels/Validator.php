<?php
namespace App\JsonApi\FuelLabels;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'fuel-labels';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'id',
      'text'
    ];

    protected $allowedIncludePaths = [
      
    ];
    
    protected $queryRules = [
      'filter.text' => 'string|min:1',
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
        $required = $record ? 'sometimes|required' : 'required';
        return [
          'text' => "nullable|string",
          'publication-date' => "nullable|date"
        ];
    }

}
