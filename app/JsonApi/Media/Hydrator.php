<?php

namespace App\JsonApi\Media;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'publishing-id',
    'media-type',
    'publication-date',
    'storage-uuid',
    'filesize',
    'page-count',
    'width',
    'height',
    'ratios',
    'duration',
    'mars-publish-id',
    'mars-shelf-number',
    'mars-archive-number',
    'title',
    'caption',
    'description',
    'og-title',
    'og-image',
    'og-description',
    'content-language'
  ];
  /**
   * @var array
   */
  protected $relationships = [
    'file-types',
    'filter-categories',
    'copyrights'
  ];
  
}
