<?php

namespace App\Repositories;

use App\Person;
use App\Share;
use App\AccessControl;

use Carbon\Carbon;

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

        if ($queryFilter->query('share') !== NULL) {
          $shares = $this->shareModel->query()->where('share_number','like', '%'.$queryFilter->query('share').'%')->get();
            if(count($shares)) {
              foreach ($shares as $key => $share) {
                $data->orWhere('share_id', $share->id);
              }
            } else {
              $data->where('share_id', '');
            }
        }
        
        if ($queryFilter->query('partner_name') !== NULL) {
          $persons = $this->personModel->where('isPartner', 1)->where('name','like', '%'.$queryFilter->query('partner_name').'%')->get();
          if(count($persons)) {
            foreach ($persons as $key => $person) {
              $data->orWhere('people_id', $person->id);
            }
          } else {
            $data->where('people_id','');
          }
        }
  
        if ($queryFilter->query('partner_rif_ci') !== NULL) {
          $persons = $this->personModel->query()->where('isPartner', 1)->where('rif_ci','like', '%'.$queryFilter->query('partner_rif_ci').'%')->get();
          if(count($persons)) {
            foreach ($persons as $key => $person) {
              $data->orWhere('people_id', $person->id);
            }
          } else {
            $data->where('people_id','');
          }
        }
  
        if ($queryFilter->query('partner_card_number') !== NULL) {
          $persons = $this->personModel->query()->where('isPartner', 1)->where('card_number','like', '%'.$queryFilter->query('partner_card_number').'%')->get();
          if(count($persons)) {
            foreach ($persons as $key => $person) {
              $data->orWhere('people_id', $person->id);
            }
          } else {
            $data->where('people_id','');
          }
        }

        if ($queryFilter->query('guest_name') !== NULL) {
          $persons = $this->personModel->query()->where('isPartner', 3)->where('name','like', '%'.$queryFilter->query('guest_name').'%')->get();
          if(count($persons)) {
            foreach ($persons as $key => $person) {
              $data->orWhere('guest_id', $person->id);
            }
          } else {
            $data->where('guest_id','');
          }
        }

        if ($queryFilter->query('guest_rif_ci') !== NULL) {
          $persons = $this->personModel->query()->where('isPartner', 3)->where('rif_ci','like', '%'.$queryFilter->query('guest_rif_ci').'%')->get();
          if(count($persons)) {
            foreach ($persons as $key => $person) {
              $data->orWhere('guest_id', $person->id);
            }
          } else {
            $data->where('guest_id','');
          }
        }

        if ($queryFilter->query('location_id') !== NULL) {
          $data->where('location_id', $queryFilter->query('location_id'));
        }

        if ($queryFilter->query('status') !== NULL) {
          $data->where('status', $queryFilter->query('status'));
        }

        if ($queryFilter->query('created_start') !== NULL && $queryFilter->query('created_end') !== NULL) {
          $data->orWhereBetween('created', [$queryFilter->query('created_start'), $queryFilter->query('created_end')]);
        }

        if ($queryFilter->query('created_order') !== NULL) {
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

    public function getVisitsByMont($id) {
       return $this->model->where('status', 1)
       ->where('guest_id', $id)
       ->whereMonth('created', '=', date('m'))
       ->get();
    }

    public function getMonthsByIsPartner($isPartner) {
      $this->isPartner = $isPartner;
      if($isPartner === 3) {
        $lastMonth =  $this->model->where('status', 1)
        ->whereNotNull('guest_id')
        ->whereHas('guest' , function($q){
          $q->where('isPartner', $this->isPartner);
        })->whereMonth('created', '=', Carbon::now()->subMonth()->month)->count();
        $currentMonth = $this->model->where('status', 1)->whereNotNull('guest_id')->whereHas('guest' , function($q){
          $q->where('isPartner', $this->isPartner);
        })->whereMonth('created', '=', date('m'))->count();
      } else {
        $lastMonth =  $this->model->where('status', 1)->whereHas('person' , function($q){
          $q->where('isPartner', $this->isPartner);
        })->whereMonth('created', '=', Carbon::now()->subMonth()->month)->count();
        $currentMonth = $this->model->where('status', 1)->whereHas('person' , function($q){
          $q->where('isPartner', $this->isPartner);
        })->whereMonth('created', '=', date('m'))->count();
      }

      $lastMonth = $lastMonth ? $lastMonth : 0;
      $currentMonth = $currentMonth ? $currentMonth : 0;
      $data = $lastMonth.'/'.$currentMonth;
      return $data;
    }

    public function getAllMonths() {
      $lastMonth =  $this->model->where('status', 1)->whereMonth('created', '=', Carbon::now()->subMonth()->month)->count();
      $currentMonth = $this->model->where('status', 1)->whereMonth('created', '=', date('m'))->count();
      $lastMonth = $lastMonth ? $lastMonth : 0;
      $currentMonth = $currentMonth ? $currentMonth : 0;
      $data = $lastMonth.'/'.$currentMonth;
      return $data;
    }

    //   SELECT month(created) ,  count(*) as cant 
//   FROM [access_controls] c , people p
//   where guest_id=NULLL 
// and p.ispartner in (1,2)
// and p.people_id= c.people_id
//   and  status=1 and year(created)=year(getdate())  
// group by  month(created)
// order by month(created)
//      $first = $this->model->whereRaw('DATEDIFF("'.Carbon::today()->format('Y-m-d').'",expiration_date) <= 30')->count();
  public function getPartnersFamilyStatistics() {
    // $data = $this->model->selectRaw('created ,year(created) year, monthname(created) month, count(*) data')
    // ->where('status', 1)
    // ->where('guest_id', NULL)
    // ->whereHas('person' , function($q){
    //   $q->whereIn('isPartner', [1,2]);
    // })->whereYear('created', '=', date('Y'))
    // ->groupBy('year', 'month', 'created')
    // ->orderBy('created', 'asc')
    // ->get();

    $data = \DB::select("SELECT month(c.created) as month ,  count(*) as cant 
    FROM access_controls c , people p
    where c.guest_id IS NULL
    and p.isPartner in (1,2)
    and p.id= c.people_id
    and  c.status= 1 and year(c.created)= year(getdate())  
    group by  month(c.created)
    order by month(c.created)
    ");
    // return $data;
    // $data = \DB::table('access_controls')
    // ->select('month(access_controls.created) as month')
    // ->join('people', 'people.id', '=', 'access_controls.people_id')
    // ->where('access_controls.status', 1)
    // ->where('access_controls.guest_id', NULL)
    // ->get();
    return $data;
  }

  public function getGuestStatistics() {
    // $data = $this->model->selectRaw('created ,year(created) year, monthname(created) month, count(*) data')
    // ->where('status', 1)
    // ->whereNotNull('guest_id')
    // ->whereHas('guest' , function($q){
    //   $q->whereIn('isPartner', [3]);
    // })->whereYear('created', '=', date('Y'))
    // ->groupBy('year', 'month', 'created')
    // ->orderBy('created', 'asc')
    // ->get();
    $data = \DB::select("SELECT month(c.created) as month ,  count(*) as cant 
    FROM access_controls c , people p
    where c.guest_id IS NOT NULL
    and p.isPartner in (3)
    and p.id= c.people_id
    and  c.status= 1 and year(c.created)= year(getdate())  
    group by  month(c.created)
    order by month(c.created)
    ");
    return $data;
  }
}