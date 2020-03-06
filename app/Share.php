<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $fillable = [
        'status',
        'father_action_number',
        'people_id',
        'payment_form_id',
        'card_people1',
        'card_people2',
        'card_people3',
        'id_titular_persona',
    ];
}
