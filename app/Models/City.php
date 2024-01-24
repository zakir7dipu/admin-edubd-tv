<?php

namespace App\Models;

use App\Models\Model;

class City extends Model
{
    /*
     |--------------------------------------------------------------------------
     | COUNTRY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }





    /*
     |--------------------------------------------------------------------------
     | STATE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }




    /*
     |--------------------------------------------------------------------------
     | USERS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function users()
    {
        return $this->hasMany(User::class, 'city_id', 'id');
    }
}
