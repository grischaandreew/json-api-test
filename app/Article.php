<?php
namespace App;

class Article extends JSONModelTranslation
{
  public $translatedAttributes = ['title', 'seo_title', 'topic', 'excerpt', 'content', 'formatted_content', 'location', 'source', 'localised_read_count', 'localised_download_count', 'localised_share_count', 'og_title', 'og_image', 'og_description'];
  protected $fillable = ['origin_id', 'url_slug', 'publication_date', 'display_date', 'read_count', 'download_count', 'share_count'];
  protected $hidden = ['translations'];
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'origin_id' => 'string',
      'url_slug' => 'string',
      'read_count' => 'int',
      'download_count' => 'int',
      'share_count' => 'int'
  ];
  
  public function audios()
  {
      return $this->belongsToMany('App\Media')->withPivot("sort")->whereMediaType("audio")->orderBy('sort', 'asc');
  }
  
  public function contactPersons()
  {
      return $this->belongsToMany('App\ContactPerson')->withPivot("sort")->orderBy('sort', 'asc');
  }
  
  public function contactPeople()
  {
    return $this->contactPersons();
  }
  
  public function documents()
  {
      return $this->belongsToMany('App\Media')->withPivot("sort")->whereMediaType("document")->orderBy('sort', 'asc');
  }
  
  public function fuelLabels()
  {
      return $this->belongsToMany('App\FuelLabel')->withPivot("sort")->orderBy('sort', 'asc');
  }
  
  public function images()
  {
      return $this->belongsToMany('App\Media')->withPivot("sort")->whereMediaType("image")->orderBy('sort', 'asc');
  }
  
  public function sections()
  {
      return $this->belongsToMany('App\Section')->withPivot("sort")->orderBy('sort', 'asc');
  }
  
  public function videos()
  {
      return $this->belongsToMany('App\Media')->withPivot("sort")->whereMediaType("video")->orderBy('sort', 'asc');
  }

}
