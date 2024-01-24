<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVOKE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function __invoke()
    {
        try {

            $payments = PaymentMethod::active()->get(['id', 'name', 'code', 'logo']);

            return  response()
                    ->json([
                        'status'        => 1,
                        'message'       => 'Success!',
                        'data'          => $payments,
                        'error'         => null
                    ]);

        } catch (\Throwable $th) {
            return  response()
                    ->json([
                        'status'        => 0,
                        'message'       => 'There was an error!',
                        'data'          => null,
                        'error'         => $th->getMessage()
                    ]);
        }
    }
}
