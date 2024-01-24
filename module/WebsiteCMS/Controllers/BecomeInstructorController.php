<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\BecomeInstructor;
use App\Traits\CheckPermission;

class BecomeInstructorController extends Controller
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
        $data['becomeInstructor']        = BecomeInstructor::find(1);
        return view('become-instructor/index', $data);
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
                'title' => 'max:200',

            ]);

            $becomeInstructor = BecomeInstructor::find($id);

            DB::transaction(function () use ($request, $becomeInstructor) {

                $becomeInstructor->update([
                    'title'                 => $request->title,
                    'short_description'     => $request->short_description,
                    'image'                 => $becomeInstructor->image,

                ]);

                $this->uploadImage($request->image, $becomeInstructor, 'image', 'become-instructor', 330, 450);
            });

            return redirect()->route('wc.become-instructor.index')->withMessage('BecomeInstructor has been updated successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('wc.become-instructor.index')->withErrors($th->getMessage());
        }
    }


}
