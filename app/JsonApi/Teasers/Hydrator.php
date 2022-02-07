<?php

namespace App\JsonApi\Teasers;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{
  /**
   * @var array
   */
  protected $attributes = [
    'title',
    #'article_id',
    'publication_date'
  ];
  /**
   * @var array
   */
  protected $relationships = [
    'article',
    #'articles',
    'fuel-labels',
    'media'
  ];

}
