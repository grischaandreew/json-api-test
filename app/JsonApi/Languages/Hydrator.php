<?php

namespace App\JsonApi\Languages;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'language-name',
    'country-name',
    'iso-language',
    'iso-country', 
    'isDefault',
    'publication_date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
  
  ];
}
