<?php
namespace App\JsonApi;

use CloudCreativity\LaravelJsonApi\Store\EloquentAdapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BaseAdapter extends EloquentAdapter
{
    /**
     * use multiple fields to identify resource
     *
     * @var string[]|null
     */
    protected $primaryKeys = null;

    /**
     * @inheritDoc
     */
    protected function isSearchOne(Collection $filters)
    {
        return false;
    }
    
    /**
     * @return string
     */
    protected function getQualifiedFieldName($fieldName)
    {
        return sprintf('%s.%s', $this->model->getTable(), $fieldName);
    }
    
    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
    }
    
    /**
     * @inheritDoc
     */
    public function exists($resourceId)
    {
        if( is_null($this->primaryKeys) ) {
            return parent::exists($resourceId);
        }
        $query = $this->newQuery();
        foreach($this->primaryKeys as $fieldName){
          $query->orWhere($this->getQualifiedFieldName($fieldName), $resourceId);
        }
        return $query->exists();
    }

    /**
     * @inheritDoc
     */
    public function find($resourceId)
    {
        if( is_null($this->primaryKeys) ) {
            return parent::find($resourceId);
        }
        $query = $this->newQuery();
        foreach($this->primaryKeys as $fieldName){
          $query->orWhere($this->getQualifiedFieldName($fieldName), $resourceId);
        }
        return $query->first();
    }


}
