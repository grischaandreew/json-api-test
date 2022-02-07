<?php
namespace App;

class FilterCategoryTranslation extends JSONModel
{
  protected $fillable = ['name', 'publication_date'];
  
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'name' => 'string'
  ];
}
