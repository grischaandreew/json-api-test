<?php

namespace App\JsonApi\ContactPeople;

use App\ContactPerson;
use App\JsonApi\BaseAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Adapter extends BaseAdapter
{
    
    /**
     * @var array
     */
    protected $defaultPagination = [
        'number' => 1,
    ];
      
    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new ContactPerson(), $paging);
    }

    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
      if ($filters->has('firstname')) {
        $query
          ->join('contact_person_translations', 'contact_people.id', '=', 'contact_person_translations.contact_person_id')
          ->where('contact_person_translations.firstname', 'like', '%' . $filters->get('firstname') . '%')
          ->distinct()
          ->select("contact_people.*");
      }
      if ($filters->has('lastname')) {
        $query
          ->join('contact_person_translations', 'contact_people.id', '=', 'contact_person_translations.contact_person_id')
          ->where('contact_person_translations.lastname', 'like', '%' . $filters->get('lastname') . '%')
          ->distinct()
          ->select("contact_people.*");
      }
      if ($filters->has('title')) {
        $query
          ->join('contact_person_translations', 'contact_people.id', '=', 'contact_person_translations.contact_person_id')
          ->where('contact_person_translations.title', 'like', '%' . $filters->get('title') . '%')
          ->distinct()
          ->select("contact_people.*");
      }
      if ($filters->has('position')) {
        $query
          ->join('contact_person_translations', 'contact_people.id', '=', 'contact_person_translations.contact_person_id')
          ->where('contact_person_translations.position', 'like', '%' . $filters->get('position') . '%')
          ->distinct()
          ->select("contact_people.*");
      }
      if ($filters->has('email')) {
        $query
          ->join('contact_person_translations', 'contact_people.id', '=', 'contact_person_translations.contact_person_id')
          ->where('contact_person_translations.email', 'like', '%' . $filters->get('email') . '%')
          ->distinct()
          ->select("contact_people.*");
      }
      if ($filters->has('phone')) {
        $query
          ->join('contact_person_translations', 'contact_people.id', '=', 'contact_person_translations.contact_person_id')
          ->where('contact_person_translations.phone', 'like', '%' . $filters->get('phone') . '%')
          ->distinct()
          ->select("contact_people.*");
      }
      if ($filters->has('mobile')) {
        $query
          ->join('contact_person_translations', 'contact_people.id', '=', 'contact_person_translations.contact_person_id')
          ->where('contact_person_translations.mobile', 'like', '%' . $filters->get('mobile') . '%')
          ->distinct()
          ->select("contact_people.*");
      }
      if ($filters->has('fax')) {
        $query
          ->join('contact_person_translations', 'contact_people.id', '=', 'contact_person_translations.contact_person_id')
          ->where('contact_person_translations.fax', 'like', '%' . $filters->get('fax') . '%')
          ->distinct()
          ->select("contact_people.*");
      }
    }

    /**
     * @inheritDoc
     */
    protected function isSearchOne(Collection $filters)
    {
        return $filters->has('email');
    }


}
