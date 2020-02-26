<?php

namespace App;

use Kodeine\Acl\Traits\HasRole;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasRole;
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
}
