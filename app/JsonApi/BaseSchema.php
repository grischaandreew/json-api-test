<?php

namespace App\JsonApi;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseSchema extends EloquentSchema
{
  
  protected $attributesIncluded = null;
  
  protected $createdAt = false;

  /**
   * Should the updated at attribute be included?
   *
   * If the model does not have timestamps, then this setting will be ignored.
   *
   * @var bool
   */
  protected $updatedAt = false;

  /**
   * Should the deleted at attribute be included?
   *
   * If the model does not use the `SoftDeletes` trait, this will be ignored.
   *
   * @var bool
   */
  protected $deletedAt = false;

  protected function getDateFormat()
  {
      return $this->dateFormat ?: Carbon::ATOM; // ISO8601
  }
  
  
  /**
   * Get attributes for the provided model using fillable attribute.
   *
   * @param Model $model
   * @return array
   */
  protected function attributeKeys(Model $model)
  {
      if( $this->isShowAttributesInIncluded && !is_null($this->attributesIncluded) ) {
          return $this->attributesIncluded;
      }
      return parent::attributeKeys($model);
  }
  
  public function getAttriutesIncluded()
  {
    return $this->attributesIncluded;
  }
  
  
}
