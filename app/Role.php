<?php

namespace App;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Model;

class Role extends EntrustRole
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

        /**
     * The professions that belong to the person.
     */
    public function permissions()
    {
        return $this->belongsToMany('App\PermissionRole', 'permission_role', 'role_id', 'permission_id');
    }
}
