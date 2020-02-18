<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'name', 
        'last_name', 
        'rif_ci', 
        'passport', 
        'card_number', 
        'expiration_date', 
        'birth_date', 
        'gender', 
        'representante', 
        'picture', 
        'id_card_picture', 
        'address', 
        'city', 
        'state', 
        'telephone1', 
        'telephone2', 
        'phone_mobile1', 
        'phone_mobile2', 
        'primary_email', 
        'secondary_email', 
        'fax', 
    ];
}
