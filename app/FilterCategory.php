<?php
namespace App;

class FilterCategory extends JSONModelTranslation
{
    public $translatedAttributes = ['name'];
    protected $fillable = ['publication_date'];
    protected $casts = [
        'id' => 'string'
    ];
}
