<?php
namespace App;

class ArticleTranslation extends JSONModel
{
    protected $fillable = [
      'title', 'seo_title', 'topic', 'excerpt',
      'content', 'formatted_content', 'location',
      'source',
      'og_title', 'og_image', 'og_description',
      'localised_read_count', 'localised_download_count', 'localised_share_count',
      'publication_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
      'id' => 'string',
      'title' => 'string',
      'seo_title' => 'string',
      'topic' => 'string',
      'excerpt' => 'string',
      'content' => 'string',
      'formatted_content' => 'string',
      'location' => 'string',
      'source' => 'string',
      'localised_read_count' => 'int',
      'localised_download_count' => 'int',
      'localised_share_count' => 'int',
      'og_title' => 'string',
      'og_image'  => 'string',
      'og_description'  => 'string'
  ];
}
