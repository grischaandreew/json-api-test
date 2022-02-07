<?php

namespace App\JsonApi\ContactPeople;


use App\ContactPerson;

use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;
use App\JsonApi\BaseSchema;

class Schema extends BaseSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'contact-people';

    protected $attributes = [
      'firstname',
      'lastname',
      'title',
      'position',
      'email',
      'phone',
      'mobile',
      'fax',
      'publication_date'    
    ];

    public function getIncludePaths()
    {
      return [
        "image",
        "filter-categories"
      ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
      if (!$resource instanceof ContactPerson) {
        throw new RuntimeException('Expecting a ContactPerson model.');
      }
      
      
      $data = [];
      if (in_array("image", $includeRelationships)) {
        $image = $resource->image();
        if ($image) {
          $data["image"] = [
            self::SHOW_SELF => true,
            self::SHOW_RELATED => false,
            self::DATA => $resource->image
          ];
        }
      }
      
      return $data;
    }

}
