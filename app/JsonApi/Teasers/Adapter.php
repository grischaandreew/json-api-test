<?php

namespace App\JsonApi\Teasers;

use App\Teaser;
use App\JsonApi\BaseAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Adapter extends BaseAdapter
{
    
    /**
     * @var array
     */
    protected $defaultPagination = [
        'number' => 1,
    ];
    
    /**
     * Default eager loading when querying many resources.
     *
     * @var string[]|null
     */
    protected $with = [
      #'article',
      #'fuelLabels',
      #'images',
      #'videos',
      #'translations'
    ];
        
    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Teaser(), $paging);
    }

    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('title')) {
          $query
            ->join('teaser_translations', 'teasers.id', '=', 'teaser_translations.teaser_id')
            ->where('teaser_translations.title', 'like', '%' . $filters->get('title') . '%')
            ->distinct()
            ->select("teasers.*");
      }
    }

}
