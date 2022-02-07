<?php

namespace App\JsonApi\Copyrights;

use App\Copyright;
use App\JsonApi\BaseAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
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
        parent::__construct(new Copyright(), $paging);
    }

    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('description')) {
          $query
            ->join('copyright_translations', 'copyrights.id', '=', 'copyright_translations.copyright_id')
            ->where('copyright_translations.description', 'like', '%' . $filters->get('description') . '%')
            ->distinct()
            ->select("copyrights.*");
      }
      if ($filters->has('owner')) {
          $query->where('copyrights.owner', $filters->get('owner') );
      }
      if ($filters->has('year')) {
          $query->where('copyrights.year', $filters->get('year') );
      }
    }
}
