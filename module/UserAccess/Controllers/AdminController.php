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
use App\Models\Country;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Module\Inventory\Models\Warehouse;
use Module\Permission\Models\Position;
use Module\HRM\Models\Employee\Employee;
use Module\UserAccess\Requests\AdminStoreRequest;
use Module\UserAccess\Requests\AdminUpdateRequest;

class AdminController extends Controller
{
    use FileUploader;
    use CheckPermission;


    public function index()
    {
        $this->hasAccess("admin-view");     // check permission

        $data['admins']             = User::Admin()
                                            ->Where('role_id','1')
                                            ->paginate(20);
        $data['table']              = User::getTableName();

        return view('admin/index', $data);
    }







    public function create()
    {
        $this->hasAccess("admin-create");     // check permission

        $data['countries'] = Country::pluck('name', 'id');
        return view('admin/create', $data);
    }






    public function store(AdminStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {
                $admin = User::create([
                    'role_id'              => 1,
                    'first_name'           =>$request->first_name,
                    'last_name'            =>$request->last_name,
                    'username'             =>$request->username,
                    'email'                =>$request->email,
                    'phone'                => $request->phone,
                    'gender'               => $request->gender,
                    'postcode'             => $request->postcode,
                    'password'             => Hash::make($request->password),
                    'country_id'           => $request->country_id,
                    'state_id'             => $request->state_id,
                    'city_id'              => $request->city_id,
                    'address_1'            => $request->address_1,
                    'image'                => 'default.png',
                    'status'               => $request->status ?? 0,
                ]);

                $this->uploadImage($request->image, $admin, 'image', 'admin', 50, 50);
            });

            return redirect()->route('ua.admin.index')->withMessage('Admin has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('ua.admin.index')->withErrors($th->getMessage());
        }
    }





    public function edit($id)
    {
        $this->hasAccess("admin-edit");     // check permission
        $data['admin'] = User::where('id', $id)->first();
        $data['countries']  = Country::pluck('name', 'id');
        return view('admin/edit', $data);
    }






    public function update(AdminUpdateRequest $request, User $admin)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $admin) {

                $admin->update([
                    'role_id'              => 1,
                    'first_name'           =>$request->first_name,
                    'last_name'            =>$request->last_name,
                    'username'             =>$request->username,
                    'email'                =>$request->email,
                    'phone'                => $request->phone,
                    'gender'               => $request->gender,
                    'postcode'             => $request->postcode,
                    'password'             => Hash::make($request->password),
                    'country_id'           => $request->country_id,
                    'state_id'             => $request->state_id,
                    'city_id'              => $request->city_id,
                    'address_1'            => $request->address_1,
                    'image'                => $admin->image,
                    'status'               => $request->status ?? 0,
                ]);

                $this->uploadImage($request->image, $admin, 'image', 'admin', 50, 50);
            });

            return redirect()->route('ua.admin.index')->withMessage('Admin has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('ua.admin.index')->withErrors($th->getMessage());
        }
    }







    public function destroy(User $admin)
    {
        try {

            if(file_exists($admin->image)) {
                unlink($admin->image);
            }
            $admin->delete();

            return redirect()->route('ua.admin.index')->withMessage('Admin has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Admin');
        }
    }










}
