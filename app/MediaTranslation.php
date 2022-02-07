<?php
namespace App;

class MediaTranslation extends JSONModel
{
  
  protected $fillable = ['title', 'caption', 'description', 'og_title', 'og_image', 'og_description'];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'title' => 'string',
      'caption' => 'string',
      'description' => 'string',
      'og_title' => 'string',
      'og_image' => 'string',
      'og_description' => 'string'
  ];
}
