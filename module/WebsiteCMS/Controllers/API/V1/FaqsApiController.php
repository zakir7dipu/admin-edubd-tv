<?php

namespace Module\WebsiteCMS\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\FAQ;
use Module\WebsiteCMS\Resources\FaqsResource;

class FaqsApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVOKE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function __invoke()
    {
        try {
            $blogs    = FaqsResource::collection(
                            FAQ::active()->serialNoAsc()->get()
                        )
                        ->response()
                        ->getData(true);

            return  response()->json([
                        'status'    => 1,
                        'message'   => count($blogs) == 0 ? 'No items found!' : 'Success!',
                        'data'      => $blogs,
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
