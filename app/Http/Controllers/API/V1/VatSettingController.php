<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\VatSetting;

class VatSettingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVOKE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function __invoke()
    {
        try {

            $vatPercentage = optional(VatSetting::active()->first())->percentage ?? 0;

            return  response()
                    ->json([
                        'status'        => 1,
                        'message'       => 'Success!',
                        'percentage'    => $vatPercentage,
                        'error'         => null
                    ]);

        } catch (\Throwable $th) {
            return  response()
                    ->json([
                        'status'        => 0,
                        'message'       => 'There was an error!',
                        'percentage'    => 0,
                        'error'         => $th->getMessage()
                    ]);
        }
    }
}
