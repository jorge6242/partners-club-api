<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $fillable = [
        'description',
        'rate',
        'apply_main',
        'apply_extension',
        'apply_chhange_user',
    ];
}
