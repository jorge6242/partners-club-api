<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [      
        'name', 
        'slug', 
        'description', 
        'route',
        'icon',
        'parent',
        'order',
        'enabled',
        'menu_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roleMenu()
    {
        return $this->hasMany('App\MenuItemRole', 'menu_item_id', 'id');
    }
}
