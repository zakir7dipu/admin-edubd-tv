<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateStoreRequest;
use App\Http\Requests\StateUpdateRequest;
use App\Models\Country;
use App\Models\State;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\CheckPermission;

class CountryController extends Controller
{
    use FileUploader;
    use CheckPermission;



    /*
    |--------------------------------------------------------------------------
    | INDEX METHOD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $this->hasAccess("country-view");

        $data['countries']  = Country::query()
                                       ->where('name', 'like', '%' . request('search') . '%')
                                       ->orWhere('code', 'like', '%' . request('search') . '%')
                                       ->with('states:id,country_id,name')->with('cities')
                                       ->withCount(['states as totalStates','cities as totalCity'])
                                       ->paginate(20);

        $data['table']      = Country::getTableName();

        return view('country/index',$data);
    }



}
