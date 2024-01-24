<?php

namespace Module\WebsiteCMS\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\SocialLink;

class SocialLinkController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVOKE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function __invoke()
    {
        try {

            $socialLinks = SocialLink::active()->serialNoAsc()->get(['id', 'name', 'url', 'icon', 'background_color', 'foreground_color']);

            return  response()->json([
                        'status'    => 1,
                        'message'   => 'Success!',
                        'data'      => $socialLinks,
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
