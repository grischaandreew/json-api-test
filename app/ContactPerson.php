<?php
namespace App;

class ContactPerson extends JSONModelTranslation
{
    public $translatedAttributes = ['firstname', 'lastname', 'title', 'position', 'email', 'phone', 'mobile', 'fax'];
    protected $fillable = ['publication_date'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string'
    ];
    
    public function image()
    {
        return $this->belongsTo('App\Media')->whereMediaType("image");
    }

}
