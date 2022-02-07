<?php

namespace App\JsonApi\Media;

use App\Media;
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
     * Default eager loading when querying many resources.
     *
     * @var string[]|null
     */
    protected $with = [
      #"file-type",
      #"filter-categories",
      #"copyrights"
    ];
    
    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Media(), $paging);
    }

    /**
     * @inheritDoc
     */
    
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('publishing-id')) {
          $query->where('media.publishing_id', $filters->get('publishing-id') );
      }
      
      if ($filters->has('media-type')) {
          $query->where('media.media_type', $filters->get('media-type') );
      }
      if ($filters->has('title')) {
        $query
          ->join('media_translations', 'media.id', '=', 'media_translations.media_id')
          ->where('media_translations.title', 'like', '%' . $filters->get('title') . '%')
          ->distinct()
          ->select("media.*");
      }
      if ($filters->has('caption')) {
        $query
          ->join('media_translations', 'media.id', '=', 'media_translations.media_id')
          ->where('media_translations.caption', 'like', '%' . $filters->get('caption') . '%')
          ->distinct()
          ->select("media.*");
      }
      if ($filters->has('description')) {
        $query
          ->join('media_translations', 'media.id', '=', 'media_translations.media_id')
          ->where('media_translations.description', 'like', '%' . $filters->get('description') . '%')
          ->distinct()
          ->select("media.*");
      }
      
      if ($filters->has('width')) {
        $query->where('media.width', $filters->get('width') );
      }
      if ($filters->has('height')) {
        $query->where('media.height', $filters->get('height') );
      }
      if ($filters->has('duration')) {
        $query->where('media.duration', $filters->get('duration') );
      }
      if ($filters->has('mars-publish-id')) {
        $query->where('media.mars_publish_id', $filters->get('mars-publish-id') );
      }
      if ($filters->has('mars-shelf-number')) {
        $query->where('media.mars_shelf_number', $filters->get('mars-shelf-number') );
      }
      if ($filters->has('mars-archive-number')) {
        $query->where('media.mars_archive_number', $filters->get('mars-archive-number') );
      }
      if ($filters->has('content-language')) {
        $query->where('media.content_language', $filters->get('content-language') );
      }
    }
}
