<?php

namespace Module\WebsiteCMS\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\Blog;
use Module\WebsiteCMS\Models\Slider;
use Module\WebsiteCMS\Resources\BlogResource;

class BlogApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVOKE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function __invoke()
    {
        try {
            $blogs    = BlogResource::collection(
                            Blog::active()->serialNoAsc()->paginate(12)
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


    public function show($slug)
    {
        try {
            $blog   = BlogResource::collection(
                Blog::query()
                    ->where('slug', $slug)
                    ->get()
            )
                ->response()
                ->getData(true);


            return  response()->json([
                'status'    => 1,
                'message'   => 'Success!',
                'data'      => $blog,
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
