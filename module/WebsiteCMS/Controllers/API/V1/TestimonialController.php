<?php

namespace Module\WebsiteCMS\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Resources\TestimonialResource;
use Module\WebsiteCMS\Models\Testimonial;

class TestimonialController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVOKE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function __invoke()
    {
        try {
            $testimonials   = TestimonialResource::collection(
                                Testimonial::active()->serialNoAsc()->paginate(12)
                            )
                            ->response()
                            ->getData(true);

            return  response()->json([
                        'status'    => 1,
                        'message'   => count($testimonials) == 0 ? 'No items found!' : 'Success!',
                        'data'      => $testimonials,
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
