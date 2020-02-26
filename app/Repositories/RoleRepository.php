<?php

namespace App\Repositories;

use App\Role;

class RoleRepository  {

    public function __construct(Role $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->where('id', $id)->with('permissions')->first();
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all() {
      return $this->model->all();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name)
    {
      $response = $this->model->where('name', $name)->first();
      if ($response) {
        return $response;
      }
      return false; 
    }

        /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('display_name', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
}