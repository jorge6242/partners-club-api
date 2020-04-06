<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'description', 
        'created',
        'status',
        'people_id',
        'department_id',
        'note_type_id',
        'subject',
        'is_sent',
    ];


    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function type()
    {
        return $this->hasOne('App\NoteType','id', 'note_type_id');
    }
}
