<?php

namespace Module\CourseManagement\Service;

use App\Models\User;
use App\Models\UserEducation;
use App\Models\UserSkill;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentService
{
    use FileUploader;

    public $student;





    public function updateOrCreateStudent($request, $id = null)
    {
        $existingInfo       = User::query()
                            ->when($id, function ($q) use ($id) {
                                $q->where('id', $id);
                            })
                            ->when(!$id, function ($q) use ($request) {
                                $q->where('email', $request->email);
                            })
                            ->first();

        $this->student   = User::updateOrCreate([
            'role_id'       => 3,
            'email'         => $request->email ?? $existingInfo->email,
        ], [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'username'      => $request->username,
            'phone'         => $request->phone,
            'gender'        => $request->gender,
            'bio'           => $request->bio,
            'password'      => $request->password ? Hash::make($request->password) : optional($existingInfo)->password,
            'image'         => optional($existingInfo)->image ?? 'default.png',
            'country_id'    => $request->country_id,
            'state_id'      => $request->state_id,
            'city_id'       => $request->city_id,
            'address_1'     => $request->address_1,
            'address_2'     => $request->address_2,
            'postcode'      => $request->postcode,
            'status'        => $request->status ?? 0,
        ]);

        $this->uploadImage($request->image, $this->student, 'image', 'student', 450, 450);
    }








    public function storeStudentEducations($request)
    {
        $this->student->userEducations()->delete();

        foreach($request->title ?? [] as $key => $title) {
            $this->student->userEducations()->create([
                'title'         => $title,
                'institute'     => $request->institute[$key],
                'session'       => $request->session[$key],
                'serial_no'     => nextSerialNo(UserEducation::class),
            ]);
        }
    }
}
