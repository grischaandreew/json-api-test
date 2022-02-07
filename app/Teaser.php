<?php
namespace App;

class Teaser extends JSONModelTranslation
{
  public $translatedAttributes = ['title'];
  protected $fillable = ['publication_date', 'article_id'];
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string'
  ];
  
  public function article()
  {
      return $this->belongsTo('App\Article');
  }
  
  public function fuelLabels()
  {
      return $this->belongsToMany('App\FuelLabel')->withPivot("sort")->orderBy('sort', 'asc');
  }
  
  public function images()
  {
      return $this->belongsToMany('App\Media')->withPivot("sort")->whereMediaType("image")->orderBy('sort', 'asc');
  }
  
  public function videos()
  {
      return $this->belongsToMany('App\Media')->withPivot("sort")->whereMediaType("video")->orderBy('sort', 'asc');
  }
  
  // this methods is needed for correct handling over json api 
  public function media()
  {
      return $this->belongsToMany('App\Media');
  }
}
