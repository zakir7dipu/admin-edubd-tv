<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderUpdateRequest;
use App\Http\Requests\SocialLinkStoreRequest;
use App\Http\Requests\SocialLinkUpdateRequest;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Slider;
use Module\WebsiteCMS\Models\SocialLink;
use App\Traits\CheckPermission;

class SocialLinkController extends Controller
{
    use FileUploader;
    use CheckPermission;




/*
|--------------------------------------------------------------------------
| INDEX METHOD
|--------------------------------------------------------------------------
*/



    public function index()
    {
        $this->hasAccess("social-link-view");

        $data['social_links']    = SocialLink::query()
                                               ->where('name', 'like', '%' . request('search') . '%')
                                               ->orWhere('icon', 'like', '%' . request('search') . '%')
                                               ->paginate(20);
        $data['table']           = SocialLink::getTableName();

        return view('social-link/index', $data);
    }





/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/


    public function create()
    {
        $this->hasAccess("social-link-create");

        $data['nextSerialNo']      = nextSerialNo(SocialLink::class);

        return view('social-link/create', $data);
    }







/*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/


    public function store(SocialLinkStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {

                $sociallink = SocialLink::create([
                    'name'                      => $request->name,
                    'url'                       => $request->url,
                    'icon'                      => $request->icon,
                    'background_color'          => $request->background_color,
                    'foreground_color'          => $request->foreground_color,
                    'serial_no'                 => $request->serial_no,
                    'status'                    => $request->status ?? 0,
                ]);

            });

            return redirect()->route('wc.social-links.index')->withMessage('Social Link has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.social-links.index')->withErrors($th->getMessage());
        }
    }





/*
|--------------------------------------------------------------------------
| EDIT METHOD
|--------------------------------------------------------------------------
*/
    public function edit($id)
    {
        $this->hasAccess("social-link-edit");

        $data['social_links'] = SocialLink::find($id);

        return view('social-link/edit', $data);
    }






/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/


    public function update(SocialLinkUpdateRequest $request, SocialLink $socialLink)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $socialLink) {

                $socialLink->update([
                    'name'                  => $request->name,
                    'url'                   => $request->url,
                    'icon'                  => $request->icon,
                    'background_color'      => $request->background_color,
                    'foreground_color'      => $request->foreground_color,
                    'serial_no'             => $request->serial_no,
                    'status'                => $request->status ?? 0,
                ]);


            });

            return redirect()->route('wc.social-links.index')->withMessage('Social Link has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.social-links.index')->withErrors($th->getMessage());
        }
    }





/*
|--------------------------------------------------------------------------
| DESTROY (METHOD)
|--------------------------------------------------------------------------
*/



    public function destroy(SocialLink $socialLink)
    {
        try {
            DB::transaction(function () use ($socialLink) {



                $socialLink->delete();
            });

            return redirect()->route('wc.social-links.index')->withMessage('Social Link has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Social Links');
        }
    }
}
