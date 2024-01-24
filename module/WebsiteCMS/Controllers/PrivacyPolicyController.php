<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\PrivacyPolicy;
use App\Traits\CheckPermission;

class PrivacyPolicyController extends Controller
{
    use CheckPermission;



/*
|--------------------------------------------------------------------------
| INDEX METHOD
|--------------------------------------------------------------------------
*/
public function index()
{
    $this->hasAccess("privacy-policy-view");

    $data['privacyPolicy']        = PrivacyPolicy::find(1);
    return view('privacy-policy/index', $data);
}






/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
public function update(Request $request, $id)
{
    try {
        $request->validate([
            'description' => 'min:2',

        ]);

        $privacyPolicy = PrivacyPolicy::find($id);

        DB::transaction(function () use ($request, $privacyPolicy) {

            $privacyPolicy->update([

                'description'                => $request->description,
            ]);


        });

        return redirect()->route('wc.privacy-policy.index')->withMessage('Privacy Policy has been updated successfully!');

    } catch (\Throwable $th) {

        return redirect()->route('wc.privacy-policy.index')->withErrors($th->getMessage());
    }
}

}
