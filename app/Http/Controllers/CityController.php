<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\CheckPermission;

class CityController extends Controller
{
    use CheckPermission;




  /*
    |--------------------------------------------------------------------------
    | INDEX METHOD
    |--------------------------------------------------------------------------
  */


    public function index(Request $request)
    {
        $this->hasAccess("city-view");

        $data['cities']     = City::query()
                            ->searchByField('country_id')
                            ->searchByField('state_id')
                            ->searchByField('name')
                            ->with('country:id,name','state:id,name')
                            ->paginate(20);

        $data['countries']  = Country::pluck('name', 'id');

        $data['states']     = State::pluck('name', 'id');
        $data['table']      = City::getTableName();


        return view('city/index',$data);
    }




    /*
    |--------------------------------------------------------------------------
    | CREATE METHOD
    |--------------------------------------------------------------------------
    */



    public function create()
    {
        $this->hasAccess("city-create");

        $data['countries'] = Country::all();
        $data['states'] = State::all();
        // dd($data);
        return view('city/create',$data);
    }


    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */



    public function store(CityStoreRequest $request)
    {
        try {
            $request->validated();
            // dd($request->all);
            DB::transaction(function () use ($request) {
                $country = $request->country;
                $state = $request->state;

                City::create([
                    'country_id'                 => $country,
                    'state_id'                   => $state,
                    'name'                       => $request->name,
                    'status'                => $request->status ?? 0,

                ]);
            });

            return redirect()->route('city.index')->withMessage('City created successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('city.index')->withErrors($th->getMessage());
        }
    }




   /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */


    public function edit($id)
    {
        $this->hasAccess("city-edit");

        $data['countries'] = Country::all();
        $data['states'] = State::all();
        $data['city'] = City::find($id);

        // dd($data);
        return view('city/edit',$data);

    }





       /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */


    public function update(CityUpdateRequest $request, $id)
    {
        try {
            $request->validated();

            $city = City::find($id);
            DB::transaction(function () use ($request, $city) {
                $country = $request->country;
                $state = $request->state;
                // dd($request->all());
                $city->update([
                    'country_id'                 => $country,
                    'state_id'                   => $state,
                    'name'                       => $request->name,
                    'status'                => $request->status ?? 0,
                ]);

                // dd($instructor);
            });

            return redirect()->route('city.index')->withMessage('City has been updated successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('city.index')->withErrors($th->getMessage());
        }
    }





    /*
    |--------------------------------------------------------------------------
    | DESTROY (METHOD)
    |--------------------------------------------------------------------------
    */


    public function destroy($id)
    {
        {
            try {
                $city = City::with('country','state')->find($id);
                DB::transaction(function () use ($city) {

                    $city->delete();
                });

                return redirect()->route('city.index')->withMessage('City has been deleted successfully!');
            } catch (\Exception $ex) {
                return redirect()->back()->withWarning('You can not delete this State');
            }
        }
    }
}
