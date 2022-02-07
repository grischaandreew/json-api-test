<?php

namespace App\JsonApi\SocialPosts;

use App\SocialPost;
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
    protected $defaultPagination = [
        'number' => 1,
    ];
    
    /**
     * use multiple fields to identify resource
     *
     * @var string[]|null
     */
    protected $primaryKeys = ["id", "origin_id"];
      
    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new SocialPost(), $paging);
    }

    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('origin-id')) {
          $query->where('social_posts.origin_id', $filters->get('origin-id') );
      }
      if ($filters->has('origin-url')) {
          $query->where('social_posts.origin_url', $filters->get('origin-url') );
      }
      if ($filters->has('title')) {
          $query->where('social_posts.title', 'like', '%' . $filters->get('title') . '%');
      }
      if ($filters->has('content')) {
          $query->where('social_posts.content', 'like', '%' . $filters->get('content') . '%');
      }
      if ($filters->has('source')) {
          $query->where('social_posts.source', $filters->get('source') );
      }
    }

    /**
     * @inheritDoc
     */
    protected function isSearchOne(Collection $filters)
    {
        return $filters->has('origin-id');
    }


}
