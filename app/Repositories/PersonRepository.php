<?php

namespace App\Repositories;

use App\Person;
use App\PersonRelation;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\RelationTypeRepository;
use App\Repositories\PersonRelationRepository;

class PersonRepository  {

    public function __construct(Person $model, PersonRelationRepository $personRelationRepository, RelationTypeRepository $relationTypeRepository) {
      $this->model = $model;
      $this->personRelationRepository = $personRelationRepository;
      $this->relationTypeRepository = $relationTypeRepository;
    }

    public function find($id) {
      $person = $this->model->where('id', $id)->with(['professions','creditCards','shares'])->first();
      $person->picture = url('storage/partners/'.$person->picture);
      return $person;
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function reportAll() {
      return $this->model->all();
    }

    public function all() {
      return $this->model->all();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkPerson($name)
    {
      $person = $this->model->where('rif_ci', $name)->first();
      if ($person) {
        return $person;
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
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }

        /**
     * seatch persons by query params
     * @param  object $queryFilter
    */
    public function searchToAssign($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->select('id', 'name', 'last_name')->where('name', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }

    /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function searchByCompany($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('type_person', 2)->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
    /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function searchPersonsToAssign($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->query()->where('id', '!=', $queryFilter->query('id'))->where('type_person', 1)->paginate($queryFilter->query('perPage'));  
      } else {
        $search = $this->model->where('id', '!=', $queryFilter->query('id'))->where('type_person', 1)->where('name', 'like', '%'.$queryFilter->query('term').'%')->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }

        /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function searchFamilyByPerson($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $person = $this->model->query()->where('id', $queryFilter->query('id'))->with('family')->first();
        $familys = $person->family()->get();
        foreach ( $familys as $key => $family) {
          $currentPerson = PersonRelation::query()->where('base_id', $queryFilter->query('id'))->where('related_id', $family->id)->first();
          $relation = $this->relationTypeRepository->find($currentPerson->relation_type_id);
          $familys[$key]->relationType = $relation;
          $familys[$key]->id = $currentPerson->id;
          $familys[$key]->status = $currentPerson->status;
        }
       return $person->family = $familys;
      } else {
        $search = $this->model->where('id', '!=', 1)->where('type_person', 1)->where('name', 'like', '%'.$queryFilter->query('term').'%')->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }

    public function assignPerson($attributes) {
      return $this->personRelationRepository->create($attributes);
    }

    public function getReportByPartner($id) {
        $person = $this->model->query()->where('id', $id)->with(['family', 'statusPerson', 'maritalStatus', 'gender', 'country','professions'])->first();
        $person['professionList'] = $this->parseProfessions($person->professions()->get());
        if($person->family()) {
          $familys = $person->family()->with(['statusPerson', 'maritalStatus', 'gender', 'country','professions'])->get();
          foreach ( $familys as $key => $family) {
            $professions = $this->parseProfessions($family->professions()->get());
            $currentPerson = PersonRelation::query()->where('base_id', $id)->where('related_id', $family->id)->first();
            $relation = $this->relationTypeRepository->find($currentPerson->relation_type_id);
            $familys[$key]->relationType = $relation;
            $familys[$key]->id = $currentPerson->id;
            $familys[$key]->professionList = $professions;
          }
          $person['familyMembers'] = $familys;
        }
        return $person;
    }

    public function parseProfessions($professions) {
      $str = '';
      $count = 0;
      foreach ( $professions as $profession) {
        $count = $count + 1;
        $coma = count($professions) == $count ? '' : ', ';
        $str .= $profession->description.''.$coma; 
      }
      return $str;
    }
}