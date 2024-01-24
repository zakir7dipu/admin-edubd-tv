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

class StateController extends Controller
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
        $this->hasAccess("sate-view");

        $data['states'] = State::query()
                        ->searchByField('country_id')
                        ->searchByField('name')
                        // ->when(request()->filled('country_id'), function ($q) {
                        //     $q->where('country_id', request('country_id'));
                        // })
                        // ->when(request()->filled('name'), function ($q) {
                        //     $q->where('name', request('name'));
                        // })
                        ->with('country:id,name','cities')
                        ->withCount(['cities as totalCity'])
                        ->paginate(20);

        // dd(request('search'));
        $data['countries']  = Country::pluck('name', 'id');
        $data['table']      = State::getTableName();
        return view('state/index',$data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */


    public function create()
    {
        $this->hasAccess("sate-create");

        $data['countries'] = Country::all();
        return view('state.create', $data);
    }


    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */



    public function store(StateStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {
                $country = $request->country;
                State::create([
                    'country_id'                 => $country,
                    'name'                       => $request->name,
                    'status'                     => $request->status ?? 0,

                ]);
            });

            return redirect()->route('state.index')->withMessage('State created successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('state.index')->withErrors($th->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $this->hasAccess("sate-edit");

        $data['countries'] = Country::all();
        $data['state'] = State::find($id);

        // dd($data);
        return view('state/edit',$data);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */

    public function update(StateUpdateRequest $request, $id)
    {
        try {
            $request->validated();

            $state = State::find($id);
            DB::transaction(function () use ($request, $state) {
                $country = $request->country;
                // dd($request->all());
                $state->update([
                    'country_id'                 => $country,
                    'name'                       => $request->name,
                    'status'                     => $request->status ?? 0,
                ]);

                // dd($instructor);
            });

            return redirect()->route('state.index')->withMessage('State has been updated successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('state.index')->withErrors($th->getMessage());
        }
    }




    /*
    |--------------------------------------------------------------------------
    | DESTROY (METHOD)
    |--------------------------------------------------------------------------
    */


    public function destroy($id)
    {
        try {
            $state = State::with('country')->find($id);
            DB::transaction(function () use ($state) {

                $state->delete();
            });

            return redirect()->route('state.index')->withMessage('State has been deleted successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this State');
        }
    }
}
