<?php
namespace App;

class JSONModelTranslation extends JSONModel
{
  use Translatable;
  protected $hidden = ['translations'];
  
}
