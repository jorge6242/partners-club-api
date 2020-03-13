<?php

namespace App\Repositories;

use App\Share;

class ShareRepository  {
  
    protected $post;

    public function __construct(Share $model) {
      $this->model = $model;
    }

    public function all($perPage) {
      return $this->model->query()->select(
        'id', 
        'share_number', 
        'father_share_id', 
        'payment_method_id', 
        'id_persona', 
        'id_titular_persona',
        'id_factura_persona',
        'id_fiador_persona',
        'share_type_id'
        )->with([
          'fatherShare' => function($query){
          $query->select('id', 'share_number'); 
          }, 
          'partner' => function($query){
          $query->select('id', 'name', 'last_name'); 
          }, 
          'titular' => function($query){
          $query->select('id', 'name', 'last_name'); 
          },
          'paymentMethod' => function($query){
          $query->select('id', 'description'); 
          }, 
          'shareType' => function($query){
          $query->select('id', 'description', 'code'); 
          }, 
     ])->paginate($perPage);
    }

    public function find($id) {
      return $this->model->query()->where('id', $id)->with(['titular', 'facturador', 'fiador', 'tarjetaPrimaria', 'tarjetaSecundaria', 'tarjetaTerciaria' ])
      ->with([ 'tarjetaPrimaria' => function($query){
            $query->with(['bank','card']);
            }
      ])->with([ 'tarjetaSecundaria' => function($query){
        $query->with(['bank','card']);
        }
      ])->with([ 'tarjetaTerciaria' => function($query){
        $query->with(['bank','card']);
        }
      ])->first();
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
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

    public function getByPartner($id) {
      return $this->model->query()->where('id_persona', $id)->with(['titular', 'facturador', 'fiador'])->with([ 'tarjetaPrimaria' => function($query){
        $query->with(['bank','card']);
        }
        ])->with([ 'tarjetaSecundaria' => function($query){
          $query->with(['bank','card']);
          }
        ])->with([ 'tarjetaTerciaria' => function($query){
          $query->with(['bank','card']);
          }
        ])->get();
    }

            /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function searchToAssign($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('share_number', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }

    public function getListByPartner($id) {
      return $this->model->query()->select('id', 'share_number')->where('id_persona', $id)->get();
    }
}