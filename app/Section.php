<?php
namespace App;

class Section extends JSONModelTranslation
{
  public $translatedAttributes = ['title', 'section_headlines'];
  protected $fillable = ['section_type', 'publication_date'];
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'section_type' => 'string'
  ];
  
  public function teasers()
  {
      return $this->belongsToMany('App\Teaser')->withPivot("sort")->orderBy('sort', 'asc');
  }

}
