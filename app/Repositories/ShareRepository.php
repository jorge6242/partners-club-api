<?php

namespace App\Repositories;

use App\Share;
use App\Person;

class ShareRepository  {
  
    protected $post;

    public function __construct(Share $model, Person $personModel) {
      $this->model = $model;
      $this->personModel = $personModel;
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
        'share_type_id',
        'status'
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

        // $search = $this->model->with('shares')->where(function($q) use($requestData, $searchQuery) {
    //   foreach ($requestData as $field) {
    //      $q->orWhere($field, 'like', "%{$searchQuery}%");
    //   }
    //   $persons = $this->shareModel->query()->where('share_number','like', '%'.$this->share.'%')->get();
    //   if(count($persons)) {
    //     foreach ($persons as $key => $value) {
    //       $q->orWhere('id', $value->id_persona);
    //     }
    //   }
    // })->whereIn('isPartner', [1,2])->paginate(8);

    public function filter($queryFilter, $isPDF = false) {
      $shares = $this->model->query()->select(
        'id', 
        'share_number',
        'status',
        'father_share_id', 
        'payment_method_id', 
        'id_persona', 
        'id_titular_persona',
        'id_factura_persona',
        'id_fiador_persona',
        'share_type_id'
        )->with([
          'shareMovements' => function($query) {
            $query->with([
              'share' => function($query){
                  $query->select('id', 'share_number'); 
              }, 
              'transaction' => function($query){
                  $query->select('id', 'description');
              }, 
              'partner' => function($query){
                  $query->select('id', 'name', 'last_name');
              },
              'titular' => function($query){
                $query->select('id', 'name', 'last_name');
              },
              'rateCurrency' => function($query){
                $query->select('id', 'description');
              },
              'saleCurrency' => function($query){
                $query->select('id', 'description');
              },
           ]);
          },
          'fatherShare' => function($query){
            $query->select('id', 'share_number'); 
          }, 
          'partner' => function($query){
            $query->select('id', 'name', 'last_name'); 
          }, 
          'titular' => function($query){
            $query->select('id', 'name', 'last_name'); 
          },
          'facturador' => function($query){
            $query->select('id', 'name', 'last_name'); 
          },
          'fiador' => function($query){
            $query->select('id', 'name', 'last_name'); 
          },
          'paymentMethod' => function($query){
            $query->select('id', 'description'); 
          }, 
          'shareType' => function($query){
            $query->select('id', 'description', 'code'); 
          }, 
      ]);
      if ($queryFilter->query('share') !== NULL) {
        $shares->where('share_number', 'like', '%'.$queryFilter->query('share').'%');
      }

      if ($queryFilter->query('father_share') !== NULL) {
        $shares->whereNull('father_share_id')->where('share_number', 'like', '%'.$queryFilter->query('father_share').'%');
      }

      if ($queryFilter->query('payment_method_id') !== NULL) {
        $shares->where('payment_method_id', $queryFilter->query('payment_method_id'));
      }

      if ($queryFilter->query('share_type') !== NULL) {
        $shares->where('share_type', $queryFilter->query('share_type'));
      }
      
      if ($queryFilter->query('status') !== NULL) {
        $shares->where('status', $queryFilter->query('status'));
      }

      if ($queryFilter->query('persona') !== NULL) {
          $filter = $queryFilter->query('persona');
          $shares->whereHas('partner', function($q) use($filter) {
            $q->where('name','like',"%{$filter}%")->orWhere('last_name','like',"%{$filter}%");
          });
      }

      if ($queryFilter->query('titular') !== NULL) {
        $filter = $queryFilter->query('titular');
        $shares->whereHas('titular', function($q) use($filter) {
          $q->where('name','like',"%{$filter}%")->orWhere('last_name','like',"%{$filter}%");
        });
      }

      if ($queryFilter->query('facturador') !== NULL) {
        $filter = $queryFilter->query('facturador');
        $shares->whereHas('facturador', function($q) use($filter) {
          $q->where('name','like',"%{$filter}%")->orWhere('last_name','like',"%{$filter}%");
        });
      }

      if ($queryFilter->query('fiador') !== NULL) {
        $filter = $queryFilter->query('fiador');
        $shares->whereHas('fiador', function($q) use($filter) {
          $q->where('name','like',"%{$filter}%")->orWhere('last_name','like',"%{$filter}%");
        });
      }

      if ($isPDF) {
        return  $shares->get();
      }
      return $shares->paginate($queryFilter->query('perPage'));
    }


    public function find($id) {
      return $this->model->query()->where('id', $id)->with(['titular', 'facturador', 'fiador', 'tarjetaPrimaria', 'tarjetaSecundaria', 'tarjetaTerciaria' ])
      ->with(['tarjetaPrimaria' => function($query){
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
      if($queryFilter->query('term') === null) {
        return  $this->model->with([
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
     ])->paginate(8);  
      } else {
        $search = $this->model->query()->with([
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
     ]);
        $search->where('share_number', 'like', '%'.$queryFilter->query('term').'%');
        $fathers = $this->model->where('father_share_id', '>',0)->where('share_number', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($fathers)) {
          foreach ($fathers as $key => $value) {
            $search->orWhere('father_share_id', $value->id);
           }
        }

        $persons = $this->personModel->query()->where('isPartner', 1)->where('name', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_persona', $value->id);
           }
        }

        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_titular_persona', $value->id);
           }
        }
        return $search->paginate(8);
      }
    }

            /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function singleSearch($queryFilter) {
      if($queryFilter->query('term') === null) {
        return  $this->model->get();  
      } else {
        $search = $this->model->query();
        $search->where('share_number', 'like', '%'.$queryFilter->query('term').'%');
        $fathers = $this->model->where('father_share_id', '>',0)->where('share_number', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($fathers)) {
          foreach ($fathers as $key => $value) {
            $search->orWhere('father_share_id', $value->id);
           }
        }

        $persons = $this->personModel->query()->where('isPartner', 1)->where('name', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_persona', $value->id);
           }
        }

        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_titular_persona', $value->id);
           }
        }
        return $search->get();
      }
    }


    public function getByPartner($id) {
      return $this->model->query()->select([
        'id',
        'share_number',
        'father_share_id',
        'status',
        'payment_method_id',
        'card_people1',
        'card_people2',
        'card_people3',
        'id_persona',
        'id_titular_persona',
        'id_factura_persona',
        'id_fiador_persona',
        'share_type_id',
    ])->where('id_persona', $id)->with(['titular', 'facturador', 'fiador','paymentMethod'])->with([ 'tarjetaPrimaria' => function($query){
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
      if($queryFilter->query('term') === null) {
        return  $this->model->with([
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
     ])->get();  
      } else {
        $search = $this->model->query()->with([
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
     ]);
        $search->where('share_number', 'like', '%'.$queryFilter->query('term').'%');
        $fathers = $this->model->where('father_share_id', '>',0)->where('share_number', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($fathers)) {
          foreach ($fathers as $key => $value) {
            $search->orWhere('father_share_id', $value->id);
           }
        }

        $persons = $this->personModel->query()->where('isPartner', 1)->where('name', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_persona', $value->id);
           }
        }

        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_titular_persona', $value->id);
           }
        }
        return $search->get();
      }
    }

    public function getListByPartner($id) {
      return $this->model->query()->select('id', 'share_number')->where('id_persona', $id)->get();
    }

    public function findByShare($share) {
      return $this->model->where('share_number', $share)->with([
        'partner' => function($q) {
          $q->select('id', 'name', 'last_name', 'rif_ci', 'card_number');
        }
        ])->first();
    }

    public function findByShareId($share) {
      return $this->model->where('id', $share)->first();
    }

    public function checkOrderCard($share, $column) {
      return $this->model->where('id', $share)->where($column, '>',0)->first();
    }
}