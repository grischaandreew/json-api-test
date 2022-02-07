<?php
namespace App\JsonApi\Sections;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

/**
 * Magazine pages are composed of sections, which are full-width areas on the page stacked on top of each other. The number of teasers and their arrangement within the section depend on the section type.
 * https://docs.google.com/document/d/128bL7055Op8EkCzC_tP5YTrrX3VRs2l-v7m9pMjLYjs
 */
class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'sections';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'id',
      'title',
      'section-headlines',
      'section-type'
    ];

    protected $allowedIncludePaths = [
      'teasers'
    ];
    
    protected $queryRules = [
      'filter.title' => 'string|min:1',
      'filter.section_headlines' => 'string|min:1',
      'filter.section_type' => 'string|min:1',
      'page.number' => 'integer|min:1',
      'page.size' => 'integer|between:1,50',
    ];
    
    /**
     * @var array
     */
    protected $allowedSortParameters = [
        'updated-at',
        'publication-date',
        'section-type'
    ];

    protected function attributeRules($record = null)
    {
        return [
          'title' => "nullable|string|between:1,255",
          'section_type' => "nullable|string|between:1,255",
          'publication-date' => "nullable|date",
        ];
    }

}
