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
}