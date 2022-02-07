<?php

namespace App\JsonApi\Magazines;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;


class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'identifier',
    'url_slug',
    'publication_date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
    'sections'
  ];
  
}
