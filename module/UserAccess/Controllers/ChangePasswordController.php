<?php


namespace Module\UserAccess\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

    /*
        |--------------------------------------------------------------------------
        | CONSTRUCTOR
        |--------------------------------------------------------------------------
       */
    public function __construct()
    {
    }









    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {

        return view('users.change_password');
    }







    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request)
    {

        $user = User::find(auth()->id());
        $request->validate([

            'new_password'      => 'required',
        ]);

        if (Hash::check($request->current_password, $user->password)){

            if ($request->new_password == $request->new_confirm_password){

                User::updateOrCreate(['id'    => auth()->id()], ['password' =>  Hash::make($request->new_password)]);

            }
            else{
                return redirect()->back()->withError('New password & confirm password are different !');
            }
        }
        else{
            return redirect()->back()->withError('Old password dont Matched !');
        }

        return redirect()->route('home')->withMessage('Password update success !');
    }

}
