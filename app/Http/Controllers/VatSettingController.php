<?php

namespace App\Http\Controllers;

use App\Models\VatSetting;
use Illuminate\Http\Request;
use App\Traits\CheckPermission;

class VatSettingController extends Controller
{
    use CheckPermission;

    public function __invoke(Request $request)
    {
        $this->hasAccess("vat-setting-edit");

        if ($request->isMethod('GET')) {
            $data['vatSetting'] = VatSetting::first();

            return view('vat-setting/index', $data);
        }


        if ($request->isMethod('POST')) {

            try {
                VatSetting::updateOrCreate(['id' => 1], [
                    'percentage'    => $request->percentage ?? 0,
                    'status'        => $request->status ?? 0,
                ]);

                return redirect()->route('vat-settings')->withMessage('Vat Setting has been updated successfully!');

            } catch (\Throwable $th) {

                return redirect()->route('vat-settings')->withErrors($th->getMessage());
            }
        }
    }
}
