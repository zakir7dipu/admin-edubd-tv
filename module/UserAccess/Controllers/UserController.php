<?php

namespace Module\UserAccess\Controllers;

use Exception;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Traits\CheckPermission;
use Module\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Module\Inventory\Models\Warehouse;
use Module\Permission\Models\Position;
use Module\HRM\Models\Employee\Employee;

class UserController extends Controller
{


    use CheckPermission;

    public function index(Request $request)
    {
        $this->hasAccess("permission.users.index");     // check permission

        $users = User::with('permissions')->where('type', '!=', 'Customer')->paginate(10000);

        return view('users/index', compact('users'));
    }







    public function create()
    {
        $this->hasAccess("permission.users.create");     // check permission

        $data['companies'] = Company::userCompanies();
        $data['roles']     = Role::with('permissions')->pluck('name', 'id');
        $data['positions'] = Position::pluck('name', 'id');

        return view('users/create', $data);
    }






    public function store(Request $request)
    {

        // <!-- Validation Data -->
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|unique:users,email',
            'password'          => 'required',
            'confirm_password'  => 'same:password',
        ]);

  
        // <!-- Store Data -->
        try {
            $newUser = User::create([
                'warehouse_id'      => $request->warehouse_id,
                'position_id'       => $request->position_id,
                'role_id'           => $request->role_id,
                'username'          => $request->username,
                'name'              => $request->name,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'company_id'        => 1,
                'password'          => Hash::make($request->password)
            ]);

            if($request->role_id){
                
                $user = User::find($newUser->id);

                $role                  = Role::find($request->role_id);
                $role_permissions      = $role->permissions()->pluck('permission_id')->toArray();
                $user->permissions()->sync($role_permissions);
                $user->permissions()->pluck('permission_id')->toArray();
            }
            

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
        

        return redirect()->route('users.index')->withMessage('User Successfully Created');
    }





    public function edit($id)
    {
        $this->hasAccess("permission.users.edit");     // check permission

        $data['roles']      = Role::pluck('name', 'id');
        $data['positions'] = Position::pluck('name', 'id');

        $data['user']       = User::findOrFail($id);
        $data['companies']  = Company::userCompanies();

        return view('users.edit', $data);
    }






    public function update(Request $request, $id)
    {

        // <!-- Validation Data -->
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|unique:users,email,'.$id,
        ]);

        // <!-- Store Data -->
        try {
            User::where('id', $id)->update([
                'name'              => $request->name,
                'username'          => $request->username,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'role_id'           => $request->role_id,
                'position_id'       => $request->position_id,

            ]);

            if($request->role_id){
                $user = User::find($id);

                $role                  = Role::find($request->role_id);
                $role_permissions      = $role->permissions()->pluck('permission_id')->toArray();
                $user->permissions()->sync($role_permissions);
                $user->permissions()->pluck('permission_id')->toArray();
            }
         
            
            if($request->password){
                User::where('id', $id)->update([
                    'password'          => Hash::make($request->password)

                ]);
            }

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
        

        return redirect()->route('users.index')->withMessage('User Successfully Updated');
    }






    public function destroy($id)
    {
        $this->hasAccess("permission.users.delete");     // check permission

        try {

            User::destroy($id);

            return redirect()->back()->withMessage('User Successfully Deleted!');

        } catch(\Exception $ex) {

            return redirect()->back()->withError('This user allready used in another');
        }
    }






    // password change page
    public function changePassword()
    {
        return view('users.change_password');
    }






    // admin change any users password
    public function AdminChangePassword($id)
    {
        return view('users.change_password_by_admin', ['user' => User::find($id)]);
    }






    // update users password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'     => ['required', new MatchOldPassword],
            'new_password'         => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

            return redirect()->back()->with('message', 'Password change successfully');

        } catch (Exception $ex) {

            return redirect()->back()->with('error', 'Some error please check');
        }
    }

    // update users password by admin
    public function AdminUpdatePassword(Request $request)
    {
        $request->validate([
            'email'             => ['required'],
            'new_password'      => ['required'],
            'confirm_password'  => ['same:new_password'],
        ]);

        try {
            User::find($request->id)->update([
                
                'email'    => $request->email,
                'password' => Hash::make($request->new_password)
            ]);
            return redirect()->back()->with('message', 'Password change successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Some error please check');
        }
    }

    public function addUserFromEmployee()
    {
        $employees = Employee::whereDoesntHave('user')->whereNotNull('email')->take(50)->get()
        ->map(function($employee) {
            return [
                'name'          => $employee->name,
                'employee_id'   => $employee->id,
                'company_id'    => $employee->company_id,
                'email'         => $employee->email,
                'password'      => Hash::make(12345678),
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        })->toArray();

        User::insert($employees);
        
        return count($employees) . ' user created successfully';
    }
}
