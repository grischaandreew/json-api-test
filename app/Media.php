<?php
namespace App;

class Media extends JSONModelTranslation
{
    public $translatedAttributes = ['title', 'caption', 'description', 'og_title', 'og_image', 'og_description'];
    protected $fillable = [
      'publishing_id',
      'media_type',
      'publication_date',
      'storage_uuid',
      'filesize',
      'page_count',
      'width',
      'height',
      'ratios',
      'duration',
      'mars_publish_id',
      'mars_shelf_number',
      'mars_archive_number',
      'content_language'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'publishing_id' => 'string',
        'media_type' => 'string',
        'storage_uuid' => 'string',
        'filesize' => 'int',
        'page_count' => 'int',
        'width' => 'int',
        'height' => 'int',
        'ratios' => 'array',
        'duration' => 'int',
        'mars_publish_id' => 'string',
        'mars_shelf_number' => 'string',
        'mars_archive_number' => 'string',
        'content_language' => 'string'
    ];
    
    public function fileType()
    {
        return $this->belongsTo('App\FileType');
    }
    
    public function filterCategories()
    {
        return $this->belongsToMany('App\FilterCategory')->withPivot("sort")->orderBy('sort', 'asc');
    }
    
    public function copyrights()
    {
        return $this->belongsToMany('App\Copyright')->withPivot("sort")->orderBy('sort', 'asc');
    }
    
    public function fuelLabels()
    {
        return $this->belongsToMany('App\FuelLabel')->withPivot("sort")->orderBy('sort', 'asc');
    }
}
