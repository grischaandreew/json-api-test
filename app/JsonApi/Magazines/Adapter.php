<?php

namespace App\JsonApi\Magazines;

use App\Magazine;
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
      #"sections"
    ];
    
    /**
     * use multiple fields to identify resource
     *
     * @var string[]|null
     */
    protected $primaryKeys = ["id", "url_slug", "identifier"];
      
    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Magazine(), $paging);
    }

    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('identifier')) {
          $query->where('identifier', $filters->get('identifier') );
      }
      if ($filters->has('url_slug')) {
          $query->where('url_slug', $filters->get('url_slug') );
      }
    }

}
