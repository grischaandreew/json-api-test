<?php
namespace App;

class FuelLabel extends JSONModelTranslation
{
    public $translatedAttributes = ['text'];
    protected $fillable = [ 'publication_date'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string'
    ];

}
