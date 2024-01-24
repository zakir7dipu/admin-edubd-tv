<?php

namespace Module\CourseManagement\Service;

use App\Models\User;
use App\Models\UserEducation;
use App\Models\UserSkill;
use App\Models\UserSocialLink;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\Hash;

class InstructorService
{
    use FileUploader;

    public $instructor;





    public function updateOrCreateInstructor($request, $id = null)
    {
        $existingInfo       = User::query()
            ->when($id, function ($q) use ($id) {
                $q->where('id', $id);
            })
            ->when(!$id, function ($q) use ($request) {
                $q->where('email', $request->email);
            })
            ->first();

        $this->instructor   = User::updateOrCreate([
            'role_id'       => 2,
            'email'         => $request->email ?? $existingInfo->email,
        ], [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'username'      => $request->username,
            'phone'         => $request->phone,
            'gender'        => $request->gender,
            'experience'    => $request->experience,
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

        $this->uploadImage($request->image, $this->instructor, 'image', 'instructor', 450, 450);
    }





    public function storeInstructorSkills($request)
    {
        $this->instructor->userSkills()->delete();

        foreach ($request->skills ?? [] as $skill) {
            $this->instructor->userSkills()->create([
                'name'          => $skill,
                'serial_no'     => nextSerialNo(UserSkill::class)
            ]);
        }
    }





    public function storeInstructorEducations($request)
    {
        $this->instructor->userEducations()->delete();

        foreach ($request->title ?? [] as $key => $title) {
            $this->instructor->userEducations()->create([
                'title'         => $title,
                'institute'     => $request->institute[$key],
                'session'       => $request->session[$key],
                'serial_no'     => nextSerialNo(UserEducation::class),
            ]);
        }
    }


    public function storeInstructorSocialLink($request)
    {

        $this->instructor->userSocialLink()->delete();
        foreach ($request->socialName ?? [] as $key => $socialName) {
            $this->instructor->userSocialLink()->create([
                'name' => $socialName,
                'url' => $request->url[$key],
                'icon' => $request->icon[$key],
                'background_color' => $request->background_color[$key],
                'foreground_color' => $request->foreground_color[$key],
                'serial_no'     => nextSerialNo(UserSocialLink::class),
            ]);
        }
    }
}
