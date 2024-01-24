<?php

namespace Module\UserAccess\Controllers;

use App\Http\Controllers\Controller;

use Module\Permission\Models\Module;
use Module\Permission\Models\Submodule;
use Exception;
use Illuminate\Http\Request;

class SubmoduleController extends Controller
{







    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $submodules = Submodule::with('module')->orderByDesc('id')->paginate(1000);

        $modules    = Module::orderBy('name')->pluck('name', 'id');

        return view('submodule', compact('submodules', 'modules'));
    }



   
    








    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([

            'name'      => 'required|unique:submodules,name',
            'module_id' => 'required'
        ]);

        try {

            Submodule::create($data);

            return redirect()->route('submodules.index')->with('message', 'Sub Module Create Successfull');

        } catch (Exception $ex) {
            
            return redirect()->back()->with('error', 'Some error, please check');
        }
    }




    







    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit(Submodule $submodule)
    {
        $modules    = Module::orderBy('name')->pluck('name', 'id');

        $submodules = Submodule::with('module')->orderBy('name')->paginate(30);

        return view('submodule', compact('modules', 'submodules', 'submodule'));
    }



    







    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, Submodule $submodule)
    {
        $data = $request->validate([

            'name'      => 'required|unique:submodules,name,' . $submodule->id,
            'module_id' => 'required'
        ]);

        try {

            $submodule->update($data);

            return redirect()->route('submodules.index')->with('message', 'Submodule Update Successfull');

        } catch (Exception $ex) {

            return redirect()->route('submodules.index')->with('error', 'Some error, please check');

        }
    }



    







    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy(Submodule $submodule)
    {
        try {

            $submodule->delete();

            return redirect()->route('submodules.index')->with('message', 'Sub Module deleted Successfull');

        } catch (Exception $ex) {

            return redirect()->back()->with('error', 'Some error, please check');
            
        }
    }
}
