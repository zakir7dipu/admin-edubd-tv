<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\AccountVerifyJob;
use App\Jobs\ResetPasswordJob;
use App\Traits\FileUploader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;


class AuthAPIController extends Controller
{
    public $user;
    public $smsresult;
    public $googleUser;

    use FileUploader;









    /*
    |--------------------------------------------------------------------------
    | LOGIN (METHOD)
    |--------------------------------------------------------------------------
    */
    public function login(LoginUserRequest $request)
    {
        try {
            $request->validated($request->all());

            $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';


            if (!auth()->attempt([$field => $request->email, 'password'=> $request->password])) {
                return  response()
                    ->json([
                        'status'        => 0,
                        'message'       => 'Credentials do not match!',
                        'user'          => null,
                        'accessToken'   => null
                    ]);
            }
          
            

            // $user   = User::where('email', $request->email)->orWhere('phone', $request->email)->first();
            $user = User::where(function ($query) use ($request) {
                $query->where('email', $request->email)
                    ->orWhere('phone', $request->email);
            })->first();
            
            if ($user->is_verified === 0 || $user->status === 0) {
                $code = rand(1111, 9999);
                // $hash_email     = Crypt::encryptString($user->email);
                // $verify_token   = $user->verify_token;
                // $verifyUrl      = env('WEB_URL') . '/account/verify/' . $verify_token . '/' . $hash_email;


                // $user->update([
                //     'code' => $code
                // ]);

                // $user_verify = [
                //     'firstName' => $user->first_name,
                //     'lastName'  => $user->last_name,
                //     'username'  => $user->username,
                //     'email'     => $user->email,
                //     'phone'     => $user->phone,
                //     'code'      => optional($user)->code,
                //     // 'verifyUrl' => $verifyUrl,
                // ];

                // dispatch(new AccountVerifyJob($user_verify));

                $url = 'https://api.greenweb.com.bd/api.php';


                $messageData = [
                    "token" =>  '84681515441679735744c09a64c70e8e8a09b6a243d19415222a',
                    "to" => '+88' . (int) $user->phone,
                    "message" => "OTP is " . $code
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($messageData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($ch);
                curl_close($ch);
                return  response()
                    ->json([
                        'status'        => 0,
                        'message'       => $user->is_verified == 0 ? 'Account is not verify! we sent a verify sms otp!' : 'This account is inactive!',
                        'user'          => null,
                        'user_phone'    => $user->phone,
                        // 'sms_data'      => $smsresult,
                        'accessToken'   => null
                    ]);
            }


            return  response()
                ->json([
                    'status'        => 1,
                    'message'       => 'Logged in successfully!',
                    'user'          => $user,
                    'accessToken'   => $user->createToken('API Token of ' . $user->name)->plainTextToken
                ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => 'There was an error!',
                    'user'          => null,
                    'accessToken'   => null,
                    'track' => $th->getMessage()
                ]);
        }
    }


    public function loginPhone(LoginUserRequest $request)
    {
        try {
            $request->validated($request->all());

            $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';


            if (!auth()->attempt([$field => $request->email, 'password'=> $request->password])) {
                return  response()
                    ->json([
                        'status'        => 0,
                        'message'       => 'Credentials do not match!',
                        'user'          => null,
                        'accessToken'   => null
                    ]);
            }
          
            // $user   = User::where('email', $request->email)->orWhere('phone', $request->email)->first();
            $user = User::where(function ($query) use ($request) {
                $query->where('email', $request->email)
                    ->orWhere('phone', $request->email);
            })->first();
            
            return  response()
                ->json([
                    'status'        => 1,
                    'message'       => 'Logged in successfully!',
                    'user'          => $user,
                    'accessToken'   => $user->createToken('API Token of ' . $user->name)->plainTextToken
                ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => 'There was an error!',
                    'user'          => null,
                    'accessToken'   => null,
                    'track' => $th->getMessage()
                ]);
        }
    }









    /*
    |--------------------------------------------------------------------------
    | REGISTER (METHOD)
    |--------------------------------------------------------------------------
    */
    public function register(RegisterUserRequest $request)
    {
        $code = rand(1111, 9999);
        try {
            $validator = $request->validated($request->all());

            DB::transaction(function () use ($request, $code) {
                // dd($code);
                $this->user = User::create([
                    'role_id'               => 3,
                    'first_name'            => $request->first_name,
                    'last_name'             => $request->last_name,
                    'username'              => $request->username,
                    'email'                 => $request->email,
                    'phone'                 => $request->phone,
                    'code'                  => $code,
                    'password'              => Hash::make($request->password),
                    // 'verify_token'          => Str::random(32),
                    'verify_token'          => Str::random(32),
                ]);


                $url = 'https://api.greenweb.com.bd/api.php';


                $messageData = [
                    "token" =>  '84681515441679735744c09a64c70e8e8a09b6a243d19415222a',
                    "to" => '+88' . (int) $request->phone,
                    "message" => "OTP is " . $code
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($messageData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $this->smsresult = curl_exec($ch);
                curl_close($ch);

                // if ($this->user) {

                //     $hash_email     = Crypt::encryptString($this->user->email);
                //     $verify_token   = $this->user->verify_token;
                //     $verifyUrl      = env('WEB_URL') . '/account/verify/' . $verify_token . '/' . $hash_email;

                //     $user = [
                //         'firstName' => $this->user->first_name,
                //         'lastName'  => $this->user->last_name,
                //         'username'  => $this->user->username,
                //         'email'     => $this->user->email,
                //         'phone'     => $this->user->phone,
                //         'code'     => $this->user->code,
                //         'verifyUrl' => $verifyUrl,
                //     ];

                //     dispatch(new AccountVerifyJob($user));
                // }
            });

            return response()
                ->json([
                    'status'        => 1,
                    'message'       => 'Registration has been completed successfully.',
                    'user'          => $this->user,
                    'sms_result'    => $this->smsresult,
                    'accessToken'   => $this->user->createToken('API Token of ' . $this->user->name)->plainTextToken
                ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => $th->getMessage(),
                    'user'          => null,
                    'accessToken'   => null
                ]);
        }
    }
     public function registerPhone(RegisterUserRequest $request)
    {
        try {
            $validator = $request->validated($request->all());

            DB::transaction(function () use ($request) {
                $this->user = User::create([
                    'role_id'               => 3,
                    'first_name'            => $request->first_name,
                    'last_name'             => $request->last_name,
                    'username'              => $request->username,
                    'email'                 => $request->email,
                    'phone'                 => $request->phone,
                    'is_verified'           => 1,
                    'status'                => 1,
                    'password'              => Hash::make($request->password),
                    'verify_token'          => Str::random(32),
                ]);
            });

            return response()
                ->json([
                    'status'        => 1,
                    'message'       => 'Registration has been completed successfully.',
                    'user'          => $this->user,
                    'accessToken'   => $this->user->createToken('API Token of ' . $this->user->name)->plainTextToken
                ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => $th->getMessage(),
                    'user'          => null,
                    'accessToken'   => null
                ]);
        }
    }

    public function phoneCheck(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'phone'    => 'required|unique:users',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Mobile number Already Used!',
            ], 
        200);
        }
        return response()->json([
            'status'        => true,
            'message'       => 'Number is Not Use'  
        ],
        200);
    }
    public function emailCheck(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'    => 'required|unique:users',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Email Address Already Used!',
            ], 
        200);
        }
        return response()->json([
            'status'        => true,
            'message'       => 'Email Address is Not Use'  
        ],
        200);
    }

    public function verifyOtp(Request $request, $phone)
    {
        try {
            // $request->validated($request->all());
            $user = User::where('phone', $phone)->first();
            // dd(intval($user->code) == $request->code);


            if ($user->code == $request->code) {
                $user->update([
                    'is_verified'  => 1,
                    'status' => 1,
                    'code' => ''
                ]);

                return  response()
                    ->json([
                        'status'        => 1,
                        'message'       => 'varify successfully!',
                        'user'          => $user
                    ]);
            } else {
                return  response()
                    ->json([
                        'status'        => 0,
                        'message'       => 'verification code do not match! ',
                        'user'          => null,
                        'accessToken'   => null
                    ]);
            }
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => 'There was an error!',
                    'user'          => null,
                    'accessToken'   => null
                ]);
        }
    }






    public function resendOtp(Request $request, $phone)
    {
        try {

            

            $user = User::where('phone', $phone)->first();
            // dd($user);
            if ($user->phone == $request->phone) {
                $newCode = rand(1111, 9999);
                $user->update([
                    'code'  => $newCode,
                ]);

                $url = 'https://api.greenweb.com.bd/api.php';


                $messageData = [
                    "token" =>  '84681515441679735744c09a64c70e8e8a09b6a243d19415222a',
                    "to" => '+88' . (int) $request->phone,
                    "message" => "OTP is " . $newCode
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($messageData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($ch);
                curl_close($ch);



                return  response()
                    ->json([
                        'status'        => 1,
                        'message'       => 'Sent verification code successfully!',
                        'user'          => $user
                        // 'smsResult'    => $smsresult
                    ]);
            } else {
                return  response()
                    ->json([
                        'status'        => 0,
                        'message'       => 'verification code do not sent! ',
                        'user'          => null,
                        'accessToken'   => null
                    ]);
            }
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => 'There was an error!',
                    'user'          => null,
                    'accessToken'   => null
                ]);
        }
    }















    /*
    |--------------------------------------------------------------------------
    | ACCOUNT VERIFY (METHOD)
    |--------------------------------------------------------------------------
    */
    public function accountVerify($verify_token, $hash_email)
    {
        try {
            $user = User::where(['email' => Crypt::decryptString($hash_email), 'verify_token' => $verify_token])->first();

            if ($user->verify_token == $verify_token) {
                $user->update([
                    'status'            => 1,
                    'is_verified'       => 1,
                    'email_verified_at' => Carbon::now(),
                    'verify_token'      => null,
                ]);

                return  response()
                    ->json([
                        'status'    => 1,
                        'message'   => 'Your account has been verified successfully!',
                    ]);
            } else if ($user->is_verified) {
                return  response()
                    ->json([
                        'status'    => 1,
                        'message'   => 'Your account already has been verified!',
                    ]);
            }
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => $th->getMessage()
                    // 'message'       => 'Account verify has been failed!',
                ]);
        }
    }











     /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD (METHOD)
    |--------------------------------------------------------------------------
    */
    public function forgotPassword(Request $request,$phone)
    {
        
        try {
            
            $user = User::where('phone', $phone)->first();

            if (!$user) {
                return response()->json(['status' => 0, 'message' => 'Phone Number not found!']);
            }

            if ($user->phone == $request->phone) {
                $newCode = rand(1111, 9999);
                $user->update([
                    'code'  => $newCode,
                ]);

                $url = 'https://api.greenweb.com.bd/api.php';


                $messageData = [
                    "token" =>  '84681515441679735744c09a64c70e8e8a09b6a243d19415222a',
                    "to" => '+88' . (int) $request->phone,
                    "message" => "OTP is " . $newCode
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($messageData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($ch);
                curl_close($ch);
               
            return  response()
            ->json([
                'status'        => 1,
                'message'       => 'Sent verification code successfully!',
                'user'          => $user
                // 'smsResult'    => $smsresult
            ]);
    } else {
        return  response()
            ->json([
                'status'        => 0,
                'message'       => 'verification code do not sent! ',
                'user'          => null,
                'accessToken'   => null
            ]);
    }
} catch (\Throwable $th) {
    return  response()
        ->json([
            'status'        => 0,
            'message'       => 'There was an error!',
            'user'          => null,
            'accessToken'   => null
        ]);
}
}

    // public function forgotPassword($email)
    // {
    //     try {
    //         $user = User::where('email', $email)->first();

    //         if (!$user) {
    //             return response()->json(['status' => 0, 'message' => 'Email not found!']);
    //         }

    //         DB::transaction(function () use ($user) {
    //             $token = Str::random(32);

    //             $hash_email     = Crypt::encryptString($user->email);
    //             $verifyUrl      = env('APP_URL') . '/account/reset-password/' . $token . '/' . $hash_email;

    //             $user = [
    //                 'firstName' => $user->first_name,
    //                 'lastName'  => $user->last_name,
    //                 'username'  => $user->username,
    //                 'email'     => $user->email,
    //                 'verifyUrl' => $verifyUrl,
    //             ];

    //             dispatch(new ResetPasswordJob($user));

    //             DB::table('password_resets')->where('email', $user['email'])->delete();
    //             DB::table('password_resets')->insert([
    //                 'email'         => $user['email'],
    //                 'token'         => $token,
    //                 'created_at'    => now()
    //             ]);
    //         });

    //         return response()->json(['status' => 1, 'message' => 'Password reset link has been sent to your email address.']);
    //     } catch (\Throwable $th) {
    //         return response()->json(['status' => 0, 'message' => $th->getMessage()]);
    //     }
    // }











    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD (METHOD)
    |--------------------------------------------------------------------------
    */
    public function resetPassword(ResetPasswordRequest $request,$phone)
    {
        // return $request->all();
        try {
            $user = User::where('phone', $phone)->first();

           
            // if ($user->phone == $request->phone) {
            //     $user->update([
            //         'password' => Hash::make($request->password)
            //     ]);
            // }
            DB::transaction(function () use ($request, $phone) {
                User::where('phone', $phone)->update([
                    'password' => Hash::make($request->password)
                ]);
            });
            
            return  response()
            ->json([
                'status'        => 1,
                'message'       => 'Password Updated successfully!',
                'user'          => $user,
                'accessToken'   => $user->createToken('API Token of ' . $user->name)->plainTextToken
            ]);
    } catch (\Throwable $th) {
        return  response()
            ->json([
                'status'        => 0,
                'message'       => 'There was an error!',
                'user'          => null,
                'accessToken'   => null,
                'track' => $th->getMessage()
            ]);
    }
    }



    public function changePassword(Request $request)
    {
        $userid = Auth::user()->id;
        $user = User::where('id', $userid)->first();
        $current_password  = $request->oldPassword;
        $new_password = $request->newPassword;
        $confirm_password = $request->confirmPassword;
        if (!Hash::check($current_password, $user->password)) {
            return response()->json([
                'error' => 'The provided password does not match our records.'
            ], 401);
        }

        if (Hash::check($new_password, $user->password)) {
            return response()->json([
                'error' => 'Please Use Different Password'
            ], 401);
        }

        if ($new_password !== $confirm_password) {
            return response()->json([
                'error' => 'New password and confirmation do not match.'
            ], 400);
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($new_password),
        ]);
        return  response()
                ->json([
                    'status'        => 1,
                    'message'       => 'Password updated successfully.',
                    'user'          => $user,
                    'accessToken'   => $user->createToken('API Token of ' . $user->name)->plainTextToken
                ], 200);
    }



    public function updateImage(Request $request)
    {
        try {

            $userid = Auth::user()->id;
            $user = User::where('id', $userid)->first();
            $user->update([

                'image'                 => $user->image,

            ]);

            $this->uploadImage($request->image, $user, 'image', 'student', 450, 450);


            return response()->json([
                'status' => 1,
                'message' => 'Profile updated successfully.',
                'data' => $user
            ]);

          } catch (\Exception $e) {

            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
          }

    }


    public function getImage()
    {
        $userid = Auth::user()->id;
        $user = User::where('id', $userid)->select('image')->first();
        return response()->json([
            'message' => 'Profile Image get successfully.',
            'data' => $user
        ], 200);
    }


    public function updateProfileInformation(Request $request)
    {
        try {

            $userid = Auth::user()->id;
            $user = User::where('id', $userid)->first();
            $user->update([

                'first_name'            => $request->first_name,
                'last_name'             => $request->last_name,
                'phone'                 => $request->phone,
                'address_1'             => $request->address_1,
                'address_2'             => $request->address_2,
                'postcode'              => $request->postcode,

            ]);

            return response()->json([
                'profileInfoStatus' => 1,
                'message' => 'Profile info updated successfully.',
                'data' => $user
            ], 200);

          } catch (\Exception $e) {

            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
          }

    }



    public function getProfileInformation()
    {
        $userid = Auth::user()->id;
        $user = User::where('id', $userid)->first();
        return response()->json([
            'message' => 'Profile Info get successfully.',
            'data' => $user
        ], 200);
    }



  public function getUser ()
  {
    $user = User::where('id',Auth()->id())->first();
    return response()->json([
        'message' => 'user Info get successfully.',
        'data' => $user
    ], 200);
  }











    /*
    |--------------------------------------------------------------------------
    | LOGOUT (METHOD)
    |--------------------------------------------------------------------------
    */
    public function logout()
    {
        try {
            auth()->user()->currentAccessToken()->delete();

            return  response()
                ->json([
                    'status'    => 1,
                    'message'   => 'You have successfully been logged out and your token has been deleted!',
                ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                ]);
        }
    }





    // google sign in or register
    public function GoogleSignIn(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                // User is already registered, so log them in
                Auth::login($user);

                return response()->json([
                    'status'        => 1,
                    'message'       => 'Login successful!',
                    'user'          => $user,
                    'accessToken'   => $user->createToken('API Token of ' . $user->name)->plainTextToken
                ]);
            }

            // User doesn't exist, so register them
            $user = User::create([
                'role_id'       => 3,
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'status'        => 1,
                'is_verified'   => $request->is_verified,
                'image'         => $request->image

            ]);

            Auth::login($user);

            return response()->json([
                'status'        => 1,
                'message'       => 'Registration and login successful!',
                'user'          => $user,
                'accessToken'   => $user->createToken('API Token of ' . $user->name)->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'        => 0,
                'message'       => $th->getMessage(),
                'user'          => null,
                'accessToken'   => null
            ]);
        }
    }
}
