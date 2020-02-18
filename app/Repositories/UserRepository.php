<?php

namespace App\Repositories;

use App\User;

class UserRepository  {
  
    protected $user;
    protected $teamUser;

    public function __construct(User $user) {
      $this->user = $user;
    }

    public function find($id) {
      return $this->user->find($id);
    }

    public function create($attributes) {
      return $this->user->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->user->find($id)->update($attributes);
    }

    public function all() {
      return $this->user->all();
    }

    public function delete($id) {
     return $this->user->find($id)->delete();
    }

    public function checkUser($email)
    {
      $user = $this->user->where('email', $email)->first();
      if ($user) {
        return true;
      }
      return false; 
    }
}