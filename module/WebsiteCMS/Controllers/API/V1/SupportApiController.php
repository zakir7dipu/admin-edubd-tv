<?php

namespace Module\WebsiteCMS\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\Support;

class SupportApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVOKE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function __invoke()
    {
        try {
            return  response()->json([
                        'status'    => 1,
                        'message'   => 'Success!',
                        'data'      => Support::first(),
                        'errors'    => null
                    ]);

        } catch (\Throwable $th) {
            return  response()
                    ->json([
                        'status'    => 0,
                        'message'   => 'There was an error!',
                        'data'      => null,
                        'error'     => $th->getMessage()
                    ]);
        }
    }
}
