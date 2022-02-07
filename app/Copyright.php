<?php
namespace App;

class Copyright extends JSONModelTranslation
{
  public $translatedAttributes = ['description'];
  protected $fillable = ['owner', 'year', 'publication_date'];
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'owner' => 'string',
      'year' => 'int'
  ];
}
