<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use App\Http\Requests\SiteInfoStoreOrUpdateRequest;
use App\Http\Requests\SiteInfoStoreRequest;
use App\Http\Requests\SiteInfoUpdateRequest;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Page;
use Module\WebsiteCMS\Models\SiteInfo;
use Module\WebsiteCMS\Models\Slider;
use App\Traits\CheckPermission;

class SiteInfoController extends Controller
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
        $this->hasAccess("site-info");

        $data['siteinfo']        = SiteInfo::find(1);
        return view('site-info/index', $data);
    }






/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
    public function update(SiteInfoUpdateRequest $request, $id)
    {
        try {
            $request->validated();

            $siteInfo = SiteInfo::find($id);

            DB::transaction(function () use ($request, $siteInfo) {

                $siteInfo->update([
                    'site_name'                  => $request->site_name,
                    'site_title'                 => $request->site_title,
                    'fav_icon'                   => $siteInfo->fav_icon,
                    'logo'                       => $siteInfo->logo,
                    'transparent_logo'           => $siteInfo->transparent_logo,
                    'address'                    => $request->address,
                    'phone'                      => $request->phone,
                    'email'                      => $request->email,
                    'short_description'          => $request->short_description,
                    'description'                => $request->description,
                ]);

                $this->uploadImage($request->fav_icon, $siteInfo, 'fav_icon','siteInfo/fav-icon', 50, 50);
                $this->uploadImage($request->logo, $siteInfo, 'logo', 'siteInfo/logo', 300, 119);
                $this->uploadImage($request->transparent_logo, $siteInfo, 'transparent_logo', 'siteInfo/transparent-logo', 300, 119);
            });

            return redirect()->route('wc.siteinfo.index')->withMessage('Site Info has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.siteinfo.index')->withErrors($th->getMessage());
        }
    }



}
