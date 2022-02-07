<?php

namespace App\JsonApi\FileTypes;

use App\FileType;
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
        parent::__construct(new FileType(), $paging);
    }
    
    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('name')) {
          $query
            ->join('file_type_translations', 'file_types.id', '=', 'file_type_translations.file_type_id')
            ->where('file_type_translations.name', 'like', '%' . $filters->get('name') . '%')
            ->distinct()
            ->select("file_types.*");
      }
      if ($filters->has('mime_types')) {
          $query->where('file_types.mime_types', 'like', '%' . $filters->get('mime_types') . '%');
      }
      if ($filters->has('file_extensions')) {
          $query->where('file_types.file_extensions', $filters->get('file_extensions') );
      }
    }
}
