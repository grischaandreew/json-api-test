<?php
namespace App;

class TeaserTranslation extends JSONModel
{
  protected $fillable = ['title', 'publication_date'];
  
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'title' => 'string'
  ];
}
