<?php

namespace App\JsonApi\FilterCategories;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'id',
    'name',
    'publication_date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
   
  ];
  
}
