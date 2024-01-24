<?php

namespace App\Models;

use App\Models\Model;

class State extends Model
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
     | CITIES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function cities()
    {
        return $this->hasMany(City::class, 'state_id', 'id');
    }





    /*
     |--------------------------------------------------------------------------
     | USERS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function users()
    {
        return $this->hasMany(User::class, 'state_id', 'id');
    }
}
