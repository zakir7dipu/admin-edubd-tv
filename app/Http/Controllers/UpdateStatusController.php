<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateStatusController extends Controller
{
    public function __invoke(Request $request, $table)
    {
        try {
            $status = $request->status == 0 ? 1 : 0;

            DB::table($table)->where('id', $request->id)->update(['status' => $status]);

            return $status;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
