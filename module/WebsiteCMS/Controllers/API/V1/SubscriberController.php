<?php

namespace Module\WebsiteCMS\Controllers\API\V1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\SubscriberVerifyJob;
use Illuminate\Support\Facades\Crypt;
use Module\WebsiteCMS\Models\Subscriber;
use Module\WebsiteCMS\Requests\SubscriberStoreRequest;

class SubscriberController extends Controller
{
    public $subscriber;





    /*
    |--------------------------------------------------------------------------
    | STORE SUBSCRIBER (METHOD)
    |--------------------------------------------------------------------------
    */
    public function store(SubscriberStoreRequest $request)
    {
        try {
            $request->validated($request->all());

            DB::transaction(function () use ($request) {
                $this->subscriber = Subscriber::create([
                    'email'         => $request->email,
                    'verify_token'  => Str::random(32),
                ]);
    
                if ($this->subscriber) {

                    $hash_email     = Crypt::encryptString($this->subscriber->email);
                    $verify_token   = $this->subscriber->verify_token;
                    $verifyUrl      = env('WEB_URL') . '/subscriber/verify/' . $verify_token . '/' . $hash_email;
                    
                    $subscriber     = [
                        'email'     => $this->subscriber->email,
                        'verifyUrl' => $verifyUrl,
                    ];
    
                    dispatch(new SubscriberVerifyJob($subscriber));
                }
            });

            return  response()
                    ->json([
                        'status'    => 1,
                        'message'   => 'Subscribed successfully. Please check your email to verify your subscription!',
                        'data'      => $this->subscriber,
                        'error'     => null
                    ]);

        } catch (\Throwable $th) {
            return  response()
                    ->json([
                        'status'    => 0,
                        'message'   => 'Something went wrong!',
                        'data'      => '',
                        'error'     => $th->getMessage()
                    ]);
        }
    }




    
    /*
    |--------------------------------------------------------------------------
    | VERIFY (METHOD)
    |--------------------------------------------------------------------------
    */
    public function verify($verify_token, $hash_email) 
    {
        try {
            $subscriber = Subscriber::where(['email' => Crypt::decryptString($hash_email), 'verify_token' => $verify_token])->first();

            if ($subscriber->verify_token == $verify_token) {
                $subscriber->update([
                    'status'            => 1,
                    'is_verified'       => 1,
                    'verify_token'      => null,
                ]);

                return  response()
                        ->json([
                            'status'    => 1,
                            'message'   => 'Your subscription has been verified successfully!',
                        ]);

            } else if ($subscriber->is_verified) {
                return  response()
                        ->json([
                            'status'    => 1,
                            'message'   => 'Your subscription already has been verified!',
                        ]);
            }

        } catch (\Throwable $th) {
            return  response()
                    ->json([
                        'status'        => 0,
                        'message'       => 'Subscription verify has been failed!',
                    ]);
        }
    }
}
