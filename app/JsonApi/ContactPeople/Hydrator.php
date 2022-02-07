<?php

namespace App\JsonApi\ContactPeople;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'firstname',
    'lastname',
    'title',
    'position',
    'email',
    'phone',
    'mobile',
    'fax',
    'publication_date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
    'media',
    'filter-categories'
  ];
  
}
