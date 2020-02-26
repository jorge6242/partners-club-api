<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function roles() {

        return $this->belongsToMany('App\Role','roles_permissions');
            
     }
     
     public function users() {
     
        return $this->belongsToMany('App\User','users_permissions');
            
     }
}
