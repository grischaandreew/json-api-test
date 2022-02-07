<?php

namespace App\JsonApi\FileTypes;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'name',
    'mime_types',
    'file_extensions',
    'publication_date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
    
  ];
  
}
