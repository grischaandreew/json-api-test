<?php
namespace App;

class CopyrightTranslation extends JSONModel
{
  protected $fillable = ['description', 'publication_date'];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'description' => 'string'
  ];
}
