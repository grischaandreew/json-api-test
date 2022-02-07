<?php
namespace App\JsonApi\Media;

use App\JsonApi\BaseValidator;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;

/**
 * Magazine pages on Mercedes me media comprise the home magazine and event special pages.
 * https://docs.google.com/document/d/128bL7055Op8EkCzC_tP5YTrrX3VRs2l-v7m9pMjLYjs
 */
class Validator extends BaseValidator
{

    /**
     * @var string
     */
    protected $resourceType = 'media';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
      'id',
      'publishing-id',
      'media-type',
      'title',
      'caption',
      'description',
      'transcription',
      'page-count',
      'width',
      'height',
      'mars-archive-number',
      'mars-publish-id',
      'mars-shelf-number',
      'duration',
      'content-language'
    ];

    protected $allowedIncludePaths = [
      "file-type",
      "filter-categories",
      "copyrights",
      "fuel-labels"
    ];
    
    protected $queryRules = [
      'filter.publishing-id' => 'string|min:1',
      'filter.media-type' => 'string|min:1',
      'filter.title' => 'string|min:1',
      'filter.caption' => 'string|min:1',
      'filter.description' => 'string|min:1',
      'filter.width' => 'integer',
      'filter.height' => 'integer',
      'filter.mars-archive-number' => 'string|min:1',
      'filter.mars-publish-id' => 'string|min:1',
      'filter.mars-shelf-number' => 'string|min:1',
      'filter.duration' => 'integer',
      'filter.content-language' => 'string|min:1',
      'page.number' => 'integer|min:1',
      'page.size' => 'integer|between:1,50',
    ];
    
    /**
     * @var array
     */
    protected $allowedSortParameters = [
        'updated-at',
        'publication-date',
        'media-type',
        'page-count',
        'filesize',
        'width',
        'height',
        'duration'
    ];

    protected function attributeRules($record = null)
    {
        return [
          'publishing-id' => 'nullable|string|between:0,255',
          'media-type'    => 'required|string|between:0,255',
          'publication-date' => 'nullable|date', 
          'storage-uuid' => 'nullable|string|between:0,255',
          'filesize' => 'nullable|integer',
          'page-count' => 'nullable|integer',
          'width' => 'nullable|integer',
          'height' => 'nullable|integer',
          #'ratios',
          'duration' => 'nullable|integer',
          'mars-publish-id' => 'nullable|string|between:0,255',
          'mars-shelf-number' => 'nullable|string|between:0,255',
          'mars-archive-number' => 'nullable|string|between:0,255',
          'content-language' => 'nullable|string|between:0,20',
          'title' => 'nullable|string|between:0,255',
          'caption' => 'nullable|string',
          'description' => 'nullable|string',
          'og-title' => 'nullable|string',
          'og-image' => 'nullable|string',
          'og-description' => 'nullable|string'          
        ];
    }

}
