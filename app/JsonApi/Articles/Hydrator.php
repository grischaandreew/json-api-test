<?php

namespace App\JsonApi\Articles;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'origin-id',
    'url-slug',
    'display-date', 'read-count', 'download-count', 'share-count',
    'title', 'seo-title', 'topic', 'excerpt',
    'content', 'formatted-content', 'location',
    'source',
    'og-title', 'og-image', 'og-description',
    'localised-read-count', 'localised-download-count', 'localised-share-count',
    'publication-date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
    'media',
    'contact-people',
    'contact-person',
    'documents',
    'fuel-labels',
    'images',
    'videos',
    'sections'      
  ];
  
  
  
}
