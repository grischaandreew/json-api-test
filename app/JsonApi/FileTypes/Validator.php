<?php
namespace App\JsonApi\FileTypes;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'file-types';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'id',
      'name',
      'mime-types',
      'file-extensions'
    ];

    protected $allowedIncludePaths = [
      
    ];
    
    protected $queryRules = [
      'filter.name' => 'string|min:1',
      'filter.mime_types' => 'integer',
      'filter.file_extensions' => 'string|min:1',
      'page.number' => 'integer|min:1',
      'page.size' => 'integer|between:1,50',
    ];
    
    /**
     * @var array
     */
    protected $allowedSortParameters = [
        'updated-at',
        'publication-date',
        'mime-types',
        'file-extensions'
    ];

    protected function attributeRules($record = null)
    {
        $required = $record ? 'sometimes|required' : 'required';

        return [
          'name' => "nullable|string|between:1,255",
          #'mime_types' => "$required",
          #'file_extensions' => "$required",
          'publication-date' => "nullable|date",
        ];
    }

}
