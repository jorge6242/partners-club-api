<?php

namespace App\Repositories;

use App\Person;

class PersonRepository  {

    public function __construct(Person $person) {
      $this->person = $person;
    }

    public function find($id) {
      return $this->person->find($id);
    }

    public function create($attributes) {
      return $this->person->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->person->find($id)->update($attributes);
    }
  
    public function all() {
      return $this->person->all();
    }

    public function delete($id) {
     return $this->person->find($id)->delete();
    }

    public function checkPerson($name)
    {
      $person = $this->person->where('rif_ci', $name)->first();
      if ($person) {
        return true;
      }
      return false; 
    }

        /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->person->all();  
      } else {
        $search = $this->person->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
}