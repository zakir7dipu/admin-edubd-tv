<?php

namespace Module\WebsiteCMS\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Resources\SliderResource;
use Module\WebsiteCMS\Models\Slider;

class SliderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVOKE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function __invoke()
    {
        try {
            $sliders    = SliderResource::collection(
                            Slider::active()->serialNoAsc()->get()
                        )
                        ->response()
                        ->getData(true);

            return  response()->json([
                        'status'    => 1,
                        'message'   => count($sliders) == 0 ? 'No items found!' : 'Success!',
                        'data'      => $sliders,
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
