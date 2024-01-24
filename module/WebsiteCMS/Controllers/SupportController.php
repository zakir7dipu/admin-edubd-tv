<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportUpdateRequest;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Support;
use Module\WebsiteCMS\Requests\BlogStoreRequest;
use Module\WebsiteCMS\Requests\BlogUpdateRequest;
use App\Traits\CheckPermission;

class SupportController extends Controller
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
    $this->hasAccess("support-view");

    $data['support']        = Support::find(1);
    return view('support/index', $data);
}






/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
public function update(SupportUpdateRequest $request, $id)
{
    try {
        $request->validated();

        $support = Support::find($id);

        DB::transaction(function () use ($request, $support) {

            $support->update([

                'description'                => $request->description,
            ]);


        });

        return redirect()->route('wc.support.index')->withMessage('Support has been updated successfully!');

    } catch (\Throwable $th) {

        return redirect()->route('wc.support.index')->withErrors($th->getMessage());
    }
}

}
