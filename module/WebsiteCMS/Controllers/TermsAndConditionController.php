<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\TermsAndCondition;
use App\Traits\CheckPermission;

class TermsAndConditionController extends Controller
{
    use CheckPermission;



/*
|--------------------------------------------------------------------------
| INDEX METHOD
|--------------------------------------------------------------------------
*/
public function index()
{
    $this->hasAccess("terms-and-condition-view");

    $data['termsAndCondition']        = TermsAndCondition::find(1);
    return view('terms-and-condition/index', $data);
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

        $termsAndCondition = TermsAndCondition::find($id);

        DB::transaction(function () use ($request, $termsAndCondition) {

            $termsAndCondition->update([

                'description'                => $request->description,
            ]);


        });

        return redirect()->route('wc.terms-and-condition.index')->withMessage('Terms And Condition has been updated successfully!');

    } catch (\Throwable $th) {

        return redirect()->route('wc.terms-and-condition.index')->withErrors($th->getMessage());
    }
}

}
