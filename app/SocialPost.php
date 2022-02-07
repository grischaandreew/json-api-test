<?php
namespace App;

class SocialPost extends JSONModel
{
  protected $fillable = ['origin_id', 'origin_url', 'title', 'content', 'source', 'publication_date'];
  
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'string',
      'origin_id' => 'string',
      'origin_url' => 'string',
      'title' => 'string',
      'content' => 'string',
      'source' => 'string'
  ];
  
  public function media()
  {
      return $this->belongsToMany('App\Media')->withPivot("sort")->orderBy('sort', 'asc');
  }
  
  public function language()
  {
      return $this->belongsTo('App\Language');
  }
  
}