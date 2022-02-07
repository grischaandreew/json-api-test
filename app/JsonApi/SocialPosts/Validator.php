<?php
namespace App\JsonApi\SocialPosts;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'social-posts';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
        'id',
        'origin-id',
        'origin-url',
        'title',
        'content', 
        'source'
    ];

    protected $allowedIncludePaths = [
      'language', 'media'
    ];
    
    protected $queryRules = [
      'filter.origin-id' => 'string|min:1',
      'filter.origin-url' => 'string|min:1',
      'filter.title' => 'string|min:1',
      'filter.content' => 'string|min:1',
      'filter.source' => 'string|min:1',
      'page.number' => 'integer|min:1',
      'page.size' => 'integer|between:1,50',
    ];
    
    /**
     * @var array
     */
    protected $allowedSortParameters = [
        'updated-at',
        'publication-date',
        'origin-id',
        'source'
    ];

    protected function attributeRules($record = null)
    {
        $required = $record ? 'sometimes|required' : 'required';

        return [
            'origin-id' => "$required|string|between:1,255",
            'origin-url' => "$required|string|between:1,755",
            'title' => "$required|string|between:1,255",
            'content' => "$required|string|min:1", 
            'source' => "$required|string|between:1,255",
            'publication-date' => "$required|string|min:1" 
        ];
    }

}
