<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\ReturnAndRefundPolicy;
use App\Traits\CheckPermission;

class ReturnAndRefundPolicyController extends Controller
{
    use CheckPermission;



/*
|--------------------------------------------------------------------------
| INDEX METHOD
|--------------------------------------------------------------------------
*/
public function index()
{
    $this->hasAccess("return-and-refund-policy-view");

    $data['returnAndRefund']        = ReturnAndRefundPolicy::find(1);
    return view('return-and-refund-policy/index', $data);
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

        $returnAndRefund = ReturnAndRefundPolicy::find($id);

        DB::transaction(function () use ($request, $returnAndRefund) {

            $returnAndRefund->update([

                'description'                => $request->description,
            ]);


        });

        return redirect()->route('wc.return-refund-policy.index')->withMessage('Return and Refund Policy has been updated successfully!');

    } catch (\Throwable $th) {

        return redirect()->route('wc.return-refund-policy.index')->withErrors($th->getMessage());
    }
}

}
