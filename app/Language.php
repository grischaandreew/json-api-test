<?php
namespace App;

class Language extends JSONModel
{
    
    protected $fillable = ['language_name', 'country_name', 'iso_language', 'iso_country', 'isDefault', 'publication_date'];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'language_name' => 'string',
        'country_name' => 'string',
        'iso_language' => 'string',
        'iso_country' => 'string',
        'isDefault' => 'boolean'
    ];
}
