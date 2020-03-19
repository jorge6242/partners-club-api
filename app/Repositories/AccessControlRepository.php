<?php

namespace App\Repositories;

use App\Person;
use App\Share;
use App\AccessControl;

class AccessControlRepository  {
  
    protected $post;

    public function __construct(
      AccessControl $model, 
      Person $personModel,
      Share $shareModel
      ) {
      $this->model = $model;
      $this->personModel = $personModel;
      $this->shareModel = $shareModel;
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
      return $this->model->query()->select([
        'id', 
        'status', 
        'created', 
        'location_id', 
        'people_id', 
        'share_id'])->with([
          'location' => function($query){
            $query->select('id', 'description'); 
          },
          'share' => function($query){
            $query->select('id', 'share_number'); 
          }
        ])->paginate($perPage);
    }

    public function filter($queryFilter, $isPDF = false) {
      $data = $this->model->query()->select([
        'id', 
        'status', 
        'created', 
        'location_id', 
        'people_id',
        'guest_id',
        'share_id'])->with([
          'guest' => function($query){
            $query->select('id', 'name', 'last_name', 'rif_ci', 'primary_email', 'isPartner'); 
          },
          'person' => function($query){
            $query->select('id', 'name', 'last_name', 'rif_ci', 'card_number', 'isPartner'); 
          },
          'location' => function($query){
            $query->select('id', 'description'); 
          },
          'share' => function($query){
            $query->select('id', 'share_number'); 
          }
        ]);

        if ($queryFilter->query('share')) {
          $shares = $this->shareModel->query()->where('share_number','like', '%'.$queryFilter->query('share').'%')->get();
            foreach ($shares as $key => $share) {
              $data->where('share_id', $share->id);
            }
        }

        if ($queryFilter->query('partner_name')) {
          $persons = $this->personModel->query()->where('isPartner', 1)->where('name','like', '%'.$queryFilter->query('partner_name').'%')->get();
            foreach ($persons as $key => $person) {
              $data->where('people_id', $person->id);
            }
        }
  
        if ($queryFilter->query('partner_rif_ci')) {
          $persons = $this->personModel->query()->where('isPartner', 1)->where('rif_ci','like', '%'.$queryFilter->query('partner_rif_ci').'%')->get();
            foreach ($persons as $key => $person) {
              $data->where('people_id', $person->id);
            }
        }
  
        if ($queryFilter->query('partner_card_number')) {
          $persons = $this->personModel->query()->where('isPartner', 1)->where('card_number','like', '%'.$queryFilter->query('partner_card_number').'%')->get();
            foreach ($persons as $key => $person) {
              $data->where('people_id', $person->id);
            }
        }

        if ($queryFilter->query('guest_name')) {
          $persons = $this->personModel->query()->where('name','like', '%'.$queryFilter->query('guest_name').'%')->get();
          foreach ($persons as $key => $person) {
            $data->where('guest_id', $person->id);
          }
        }

        if ($queryFilter->query('guest_rif_ci')) {
          $persons = $this->personModel->query()->where('rif_ci','like', '%'.$queryFilter->query('guest_rif_ci').'%')->get();
          foreach ($persons as $key => $person) {
            $data->where('guest_id', $person->id);
          }
        }

        if ($queryFilter->query('location_id')) {
          $data->where('location_id', $queryFilter->query('location_id'));
        }

        if ($queryFilter->query('status')) {
          $data->where('status', $queryFilter->query('status'));
        }

        if ($queryFilter->query('created_start') && $queryFilter->query('created_end')) {
          $data->orWhereBetween('created', [$queryFilter->query('created_start'), $queryFilter->query('created_end')]);
        }

        if ($queryFilter->query('created_order')) {
          $data->orderBy('created', $queryFilter->query('created_order'));
        }

      if ($isPDF) {
        return  $data->get();
      }
      return $data->paginate($queryFilter->query('perPage'));
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