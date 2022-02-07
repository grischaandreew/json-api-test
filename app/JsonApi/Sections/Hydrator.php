<?php

namespace App\JsonApi\Sections;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'title',
    'section-headlines',
    'section-type',
    'publication-date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
    'teasers'
  ];
  
}
