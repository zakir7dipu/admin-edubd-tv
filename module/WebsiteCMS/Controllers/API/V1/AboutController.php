<?php

namespace Module\WebsiteCMS\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\About;

class AboutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVOKE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function __invoke()
    {
        try {
            $about  = About::with(['aboutCounts' => fn ($q) => $q->select('id', 'about_id', 'title', 'count')])->first();

            return  response()->json([
                        'status'    => 1,
                        'message'   => 'Success!',
                        'data'      => $about,
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
