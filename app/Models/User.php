<?php

namespace App\Models;

use App\Traits\CreatedByUpdatedBy;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Module\CourseManagement\Models\Course;
use Module\UserAccess\Models\Permission;
use Module\CourseManagement\Models\CourseInstructor;
use Module\CourseManagement\Models\CourseReview;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CreatedByUpdatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'role_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'gender',
        'experience',
        'bio',
        'image',
        'country_id',
        'state_id',
        'city_id',
        'address_1',
        'address_2',
        'postcode',
        'status',
        'is_verified',
        'verify_token',
        'password',
        'code',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];





    /*
     |--------------------------------------------------------------------------
     | GET IMAGE ATTRIBUTE
     |--------------------------------------------------------------------------
    */
    public function getImageAttribute()
    {
        $image = $this->attributes['image'];

        if ($image && file_exists(public_path($image))) {
            return $image;
        }else{
            return 'assets/img/avatar.png';
        }
    }





    /*
     |--------------------------------------------------------------------------
     | GET TABLE NAME
     |--------------------------------------------------------------------------
    */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }





    /*
     |--------------------------------------------------------------------------
     | SEARCH DATA BY FIELD NAME
     |--------------------------------------------------------------------------
    */
    public function scopeSearchByField($query, $filed_name)
    {
        $query->when(request()->filled($filed_name), function($qr) use($filed_name) {
           $qr->where($filed_name, request()->$filed_name);
        });
    }





    /*
     |--------------------------------------------------------------------------
     | ADMIN (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeAdmin($query)
    {
        $query->where('role_id', 1);
    }





    /*
     |--------------------------------------------------------------------------
     | INSTRUCTOR (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeInstructor($query)
    {
        $query->where('role_id', 2);
    }





    /*
     |--------------------------------------------------------------------------
     | STUDENT (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeStudent($query)
    {
        $query->where('role_id', 3);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATED BY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATED BY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }





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
     | STATE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }





    /*
     |--------------------------------------------------------------------------
     | CITY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }





    /*
     |--------------------------------------------------------------------------
     | PERMISSIONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->where('status', 1);
    }





    /*
     |--------------------------------------------------------------------------
     | ACTIVE PERMISSIONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function activePermissions()
    {
        return $this->belongsToMany(Permission::class)->where('status', 1);
    }





    /*
     |--------------------------------------------------------------------------
     | USER EDUCATIONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function userEducations()
    {
        return $this->hasMany(UserEducation::class, 'user_id');
    }





    /*
     |--------------------------------------------------------------------------
     | USER PRIMARY EDUCATION (RELATION)
     |--------------------------------------------------------------------------
    */
    public function userPrimaryEducation()
    {
        return $this->hasOne(UserEducation::class, 'user_id')->orderBy('id', 'ASC');
    }





    /*
     |--------------------------------------------------------------------------
     | USER SKILLS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function userSkills()
    {
        return $this->hasMany(UserSkill::class, 'user_id');
    }


      /*
     |--------------------------------------------------------------------------
     | USER COURSE (RELATION)
     |--------------------------------------------------------------------------
    */

    public function courseInstructors()
    {
        return $this->hasMany(CourseInstructor::class, 'instructor_id');
    }



    public function couponUses()
    {
        return $this->hasMany(CouponUses::class, 'student_id', 'id');
    }

     /*
     |--------------------------------------------------------------------------
     | USER SOCIAL LINK (RELATION)
     |--------------------------------------------------------------------------
    */
    public function userSocialLink()
    {
        return $this->hasMany(UserSocialLink::class, 'user_id','id');
    }



    public function courseReview()
    {
        return $this->hasMany(CourseReview::class, 'user_id', 'id');
    }
    public static function hasAccess($slug)
    {
        $user_id = auth()->id();
        if ($user_id != 1) {
            $permission = Permission::where('slug', $slug)->first();
            if ($permission) {
                $permission_user = PermissionUser::where('permission_id', $permission->id)->where('user_id', $user_id)->first();
                if (!$permission_user) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    public function scopeHasModuleAccess($query)
    {
        $query->whereHas('permissions', function ($q) {
            $q->whereHas('parent_permission', function($q){
                $q->where('submodule_id', '170000');
            });
        });
    }


}
