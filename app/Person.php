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
        'representante', 
        'picture', 
        'id_card_picture', 
        'address', 
        'telephone1', 
        'telephone2', 
        'phone_mobile1', 
        'phone_mobile2', 
        'primary_email', 
        'secondary_email', 
        'fax',
        'city',
        'state',
        'postal_code',
        'status_person_id',
        'marital_statuses_id',
        'gender_id',
        'countries_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statusPerson()
    {
        return $this->belongsTo('App\StatusPerson', 'status_person_id', 'id');
    }
    
   /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function maritalStatus()
   {
       return $this->belongsTo('App\MaritalStatus', 'marital_statuses_id', 'id');
   }

      /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function gender()
    {
        return $this->belongsTo('App\Gender', 'gender_id', 'id');
    }

          /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function country()
    {
        return $this->belongsTo('App\Country', 'countries_id', 'id');
    }
}
