<?php
namespace App;

class FileType extends JSONModelTranslation
{
  public $translatedAttributes = ['name'];
  protected $fillable = ['mime_types', 'file_extensions', 'publication_date'];
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'mime_types' => 'array',
      'file_extensions' => 'array'
  ];
}
