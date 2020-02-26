<?php

namespace App;

use Kodeine\Acl\Traits\HasPermission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasPermission;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
    
}
