<?php
namespace App;

class Magazine extends JSONModel
{
    protected $fillable = ['identifier', 'url_slug', 'publication_date'];
    protected $hidden = ['translations'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'identifier' => 'string',
        'url_slug' => 'string'
    ];
    
    public function sections()
    {
        return $this->belongsToMany('App\Section')->withPivot("sort")->orderBy('sort', 'asc');
    }
}
