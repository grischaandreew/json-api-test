<?php

namespace App\JsonApi\Copyrights;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'description',
    'owner',
    'year',
    'publication_date'
  ];
  /**
   * @var array
   */
  protected $relationships = [];
  
}
