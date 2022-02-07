<?php
namespace App;

class FuelLabelTranslation extends JSONModel
{
  protected $fillable = ['text', 'publication_date'];
  
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'text' => 'string'
  ];
}
