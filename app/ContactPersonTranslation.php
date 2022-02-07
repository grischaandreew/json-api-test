<?php
namespace App;

class ContactPersonTranslation extends JSONModel
{
  protected $fillable = ['firstname', 'lastname', 'title', 'position', 'email', 'phone', 'mobile', 'fax', 'publication_date'];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'firstname' => 'string',
      'lastname' => 'string',
      'title' => 'string',
      'position' => 'string',
      'email' => 'string',
      'phone' => 'string',
      'mobile' => 'string',
      'fax' => 'string'
  ];
}
