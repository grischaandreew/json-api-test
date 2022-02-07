<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class JSONModel extends Model
{
    use UuidForKey;
    #use \Venturecraft\Revisionable\RevisionableTrait;
    
    protected $primaryKey = "id";
    
    public $timestamps = true;
    
    public function getDates()
    {
        return array_merge(["publication_date"], parent::getDates());
    }
}
