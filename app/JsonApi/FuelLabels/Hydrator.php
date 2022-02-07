<?php

namespace App\JsonApi\FuelLabels;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'text',
    'publication-date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
    
  ];
  
}
