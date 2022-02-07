<?php
namespace App\JsonApi\Teasers;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

/**
 * Content on Mercedes me media magazine pages is displayed in the form of clickable rectangular tiles known as teasers.
 * https://docs.google.com/document/d/128bL7055Op8EkCzC_tP5YTrrX3VRs2l-v7m9pMjLYjs
 */
class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'teasers';
    
    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'title'
    ];

    protected $allowedIncludePaths = [
      'article',
      'fuel-labels',
      'images',
      'videos'
    ];
    
    protected $queryRules = [
      'filter.title' => 'string|min:1',
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
          'title' => "nullable|string|between:1,255",
          'publication-date' => "nullable|date",
        ];
    }

}
