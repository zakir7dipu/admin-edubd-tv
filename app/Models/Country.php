<?php

namespace App\Models;

use App\Models\Model;

class Country extends Model
{
    /*
     |--------------------------------------------------------------------------
     | STATES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function states()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }





    /*
     |--------------------------------------------------------------------------
     | CITIES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function cities()
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }





    /*
     |--------------------------------------------------------------------------
     | USERS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function users()
    {
        return $this->hasMany(User::class, 'country_id', 'id');
    }
}
