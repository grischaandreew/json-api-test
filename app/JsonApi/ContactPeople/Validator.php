<?php
namespace App\JsonApi\ContactPeople;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;


class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'contact-people';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'id',
      'firstname',
      'lastname',
      'title',
      'position',
      'email',
      'phone',
      'mobile',
      'fax'
    ];

    protected $allowedIncludePaths = [
      
    ];
    
    protected $queryRules = [
      'filter.firstname' => 'string|min:1',
      'filter.lastname' => 'string|min:1',
      'filter.title' => 'string|min:1',
      'filter.position' => 'string|min:1',
      'filter.email' => 'string|min:1',
      'filter.phone' => 'string|min:1',
      'filter.mobile' => 'string|min:1',
      'filter.fax' => 'string|min:1',
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
          'firstname' => "$required|string|between:1,255",
          'lastname' => "$required|string|between:1,255",
          'title' => "nullable|string|between:1,255",
          'position' => "nullable|string|between:1,255",
          'email' => "nullable|string|min:1",
          'phone' => "nullable|string|min:1",
          'mobile' => "nullable|string|min:1",
          'fax' => "nullable|string|min:1",
          'publication-date' => "nullable|date",
        ];
    }
}
