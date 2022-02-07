<?php

namespace App\JsonApi\SocialPosts;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'origin-id',
    'origin-url',
    'title',
    'content', 
    'source',
    'publication-date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
    'language',
    'media'
  ];
  
}
