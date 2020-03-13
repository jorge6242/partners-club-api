<?php

namespace App\Repositories;

use App\AccessControl;

class AccessControlRepository  {
  
    protected $post;

    public function __construct(AccessControl $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id, ['id', 'status', 'created', 'location_id', 'people_id', 'share_id']);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($perPage) {
      return $this->model->query()->select(['id', 'status', 'created', 'location_id', 'people_id', 'share_id'])->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select(['id', 'status', 'created', 'location_id', 'people_id', 'share_id'])->get();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name)
    {
      $data = $this->model->where('description', $name)->first();
      if ($data) {
        return true;
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
        $search = $this->model->where('description', 'like', '%'.$queryFilter->query('term').'%')->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }
}