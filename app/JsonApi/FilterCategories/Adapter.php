<?php

namespace App\JsonApi\FilterCategories;

use App\FilterCategory;
use App\JsonApi\BaseAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use CloudCreativity\LaravelJsonApi\Store\EloquentAdapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Adapter extends BaseAdapter
{
    
    /**
     * @var array
     */
    //protected $defaultPagination = [
    //    'number' => 1,
    //];
      
    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new FilterCategory(), $paging);
    }

    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('name')) {
        $query
          ->join('filter_category_translations', 'filter_categories.id', '=', 'filter_category_translations.filter_category_id')
          ->where('filter_category_translations.name', 'like', '%' . $filters->get('name') . '%')
          ->distinct()
          ->select("filter_categories.*");
      }
    }
}
