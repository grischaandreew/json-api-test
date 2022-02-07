<?php

namespace App\JsonApi\FuelLabels;

use App\FuelLabel;
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
     * Default eager loading when querying many resources.
     *
     * @var string[]|null
     */
    protected $with = [];
      
    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new FuelLabel(), $paging);
    }

    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('text')) {
        $query
          ->join('fuel_label_translations', 'fuel_labels.id', '=', 'fuel_label_translations.fuel_label_id')
          ->where('fuel_label_translations.text', 'like', '%' . $filters->get('text') . '%')
          ->distinct()
          ->select("fuel_labels.*");
      }
    }

}
