<?php

namespace App\Repositories;

use App\Bank;

class BankRepository  {
  
    protected $post;

    public function __construct(Bank $bank) {
      $this->bank = $bank;
    }

    public function find($id) {
      return $this->bank->find($id);
    }

    public function create($attributes) {
      return $this->bank->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->bank->find($id)->update($attributes);
    }
  
    public function all() {
      return $this->bank->all();
    }

    public function delete($id) {
     return $this->bank->find($id)->delete();
    }

    public function checkBank($name)
    {
      $bank = $this->bank->where('description', $name)->first();
      if ($bank) {
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
        $search = $this->bank->all();  
      } else {
        $search = $this->bank->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
}