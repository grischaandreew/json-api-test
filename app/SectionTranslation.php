<?php
namespace App;

class SectionTranslation extends JSONModel
{
  protected $fillable = ['title', 'section_headlines', 'publication_date'];
  
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'title' => 'string',
      'section_headlines' => 'array'
  ];
}
