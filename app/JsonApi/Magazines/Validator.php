<?php
namespace App\JsonApi\Magazines;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

// this documentation will be used by JsonDocApi, rendered as markdown at entity object
/**
 * Magazine pages on Mercedes me media comprise the home magazine and event special pages.
 * https://docs.google.com/document/d/128bL7055Op8EkCzC_tP5YTrrX3VRs2l-v7m9pMjLYjs
 */
class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'magazines';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'id',
      'identifier',
      'url-slug'
    ];

    protected $allowedIncludePaths = [
      "sections",
      "sections.teasers",
      "sections.teasers.images",
      "sections.teasers.videos",
      "sections.teasers.media",
      "sections.teasers.fuel-labels",
      "sections.teasers.articles",
      "sections.teasers.filter-categories",
      "sections.teasers.articles.audios",
      "sections.teasers.articles.contact-people",
      "sections.teasers.articles.documents",
      "sections.teasers.articles.fuel-labels",
      //"sections.teasers.articles.images",
      //"sections.teasers.articles.videos
    ];
    
    protected $queryRules = [
      'filter.identifier' => 'string|min:1',
      'filter.url-slug' => 'string|min:1',
      'page.number' => 'integer|min:1',
      'page.size' => 'integer|between:1,50',
    ];
    
    /**
     * @var array
     */
    protected $allowedSortParameters = [
        'updated-at',
        'publication-date',
        'identifier'
    ];

    protected function attributeRules($record = null)
    {
        $required = $record ? 'sometimes|required' : 'required';

        return [
          'identifier' => "nullable|string|between:1,255",
          'url-slug' => "nullable|string|between:1,255",
          'publication-date' => "nullable|date",
        ];
    }

}
