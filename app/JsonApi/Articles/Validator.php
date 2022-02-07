<?php
namespace App\JsonApi\Articles;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

// this documentation will be used by JsonDocApi, rendered as markdown at entity object
/**
 * Clicking on a teaser opens up an article detail page with additional information. Article detail pages contain a full-width header image at the top of the page.
 * https://docs.google.com/document/d/128bL7055Op8EkCzC_tP5YTrrX3VRs2l-v7m9pMjLYjs
 */
class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'articles';
    
    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'id',
      'origin-id',
      'url-slug',
      'title',
      'topic',
      'excerpt',
      'content',
      'location',
      'source',
      'search'
    ];

    protected $allowedIncludePaths = [
      "audios",
      "contact-people",
      "documents",
      "fuel-labels",
      "images",
      "videos",
      "media"
    ];
    
    protected $queryRules = [
      'filter.origin-id' => 'string|min:1',
      'filter.url-slug' => 'string|min:1',
      'filter.title' => 'string|min:1',
      'filter.seo-title' => 'string|min:1',
      'filter.topic' => 'string|min:1',
      'filter.excerpt' => 'string|min:1',
      'filter.content' => 'string|min:1',
      'filter.formatted-content' => 'string|min:1',
      'filter.location' => 'string|min:1',
      'filter.source' => 'string|min:1',
      'filter.search' => 'string|min:1',
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
        'url-slug',
        'read-count',
        'download-count',
        'share-count'
    ];

    protected function attributeRules($record = null)
    {
        #$required = $record ? 'sometimes|required' : 'required';
        
        return [
          'origin-id' => 'nullable|string|between:0,255',
          'url-slug' => 'nullable|string|between:0,255',
          'publication-date' => 'nullable|date',
          'display-date' => 'nullable|date',
          'read-count' => 'nullable|integer',
          'download-count' => 'nullable|integer',
          'share-count' => 'nullable|integer',
          'title' => 'nullable|string',
          'seo-title' => 'nullable|string',
          'topic' => 'nullable|string',
          'excerpt' => 'nullable|string',
          'content' => 'nullable|string',
          'formatted-content' => 'nullable|string',
          'location' => 'nullable|string|between:0,255',
          'source' => 'nullable|string|between:0,255',
          'localised-read-count' => 'nullable|integer',
          'localised-download-count' => 'nullable|integer',
          'localised-share-count' => 'nullable|integer',
          'og-title' => 'nullable|string',
          'og-image' => 'nullable|string',
          'og-description' => 'nullable|string'
        ];
    }
}
