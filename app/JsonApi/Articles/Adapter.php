<?php

namespace App\JsonApi\Articles;

use App\Article;
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
     * use multiple fields to identify resource
     *
     * @var string[]|null
     */
    protected $primaryKeys = ["id", "origin_id", "url_slug"];
    
    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Article(), $paging);
    }
    
    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('origin-id')) {
          $query->where('articles.origin_id', $filters->get('origin-id') );
      }
      if ($filters->has('url-slug')) {
          $query->where('articles.url_slug', $filters->get('url-slug') );
      }
      if ($filters->has('title')) {
          $query
            ->join('article_translations', 'articles.id', '=', 'article_translations.article_id')
            ->where('article_translations.title', 'like', '%' . $filters->get('title') . '%')
            ->distinct()
            ->select("articles.*");
      }
      if ($filters->has('topic')) {
        $query
          ->join('article_translations', 'articles.id', '=', 'article_translations.article_id')
          ->where('article_translations.topic', 'like', '%' . $filters->get('topic') . '%')
          ->distinct()
          ->select("articles.*");
      }
      if ($filters->has('excerpt')) {
        $query
          ->join('article_translations', 'articles.id', '=', 'article_translations.article_id')
          ->where('article_translations.excerpt', 'like', '%' . $filters->get('excerpt') . '%')
          ->distinct()
          ->select("articles.*");
      }
      if ($filters->has('content')) {
        $query
          ->join('article_translations', 'articles.id', '=', 'article_translations.article_id')
          ->where('article_translations.content', 'like', '%' . $filters->get('content') . '%')
          ->distinct()
          ->select("articles.*");
      }
      if ($filters->has('location')) {
        $query
          ->join('article_translations', 'articles.id', '=', 'article_translations.article_id')
          ->where('article_translations.location', 'like', '%' . $filters->get('location') . '%')
          ->distinct()
          ->select("articles.*");
      }
      if ($filters->has('source')) {
        $query
          ->join('article_translations', 'articles.id', '=', 'article_translations.article_id')
          ->where('article_translations.source', 'like', '%' . $filters->get('source') . '%')
          ->distinct()
          ->select("articles.*");
      }
      
      if ($filters->has('search')) {
        $query
          ->join('article_translations', 'articles.id', '=', 'article_translations.article_id');
        
        $query->where(function($query) use ($filters){
          $query
            ->orWhere('article_translations.title', 'like', '%' . $filters->get('search') . '%')
            ->orWhere('article_translations.content', 'like', '%' . $filters->get('search') . '%');
        });    
        
        $query->distinct()
          ->select("articles.*");
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
