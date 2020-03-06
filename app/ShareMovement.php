<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareMovement extends Model
{
    protected $fillable = [
        'share_number',
        'description',
        'sale_price',
        'transaction_type_id',
        'people_id',
        'id_titular_persona',
    ];
}
