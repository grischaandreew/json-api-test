<?php

namespace App\JsonApi\Sections;

use App\Section;
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
      #'teasers'
    ];
      
    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Section(), $paging);
    }

    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('title')) {
        $query
          ->join('section_translations', 'sections.id', '=', 'section_translations.section_id')
          ->where('section_translations.title', 'like', '%' . $filters->get('title') . '%')
          ->distinct()
          ->select("sections.*");
      }
      if ($filters->has('section-headlines')) {
        $query
          ->join('section_translations', 'sections.id', '=', 'section_translations.section_id')
          ->where('section_translations.section_headlines', 'like', '%' . $filters->get('section-headlines') . '%')
          ->distinct()
          ->select("sections.*");
      }
      if ($filters->has('section-type')) {
          $query->where('sections.section_type', $filters->get('section-type') );
      }
    }
}
