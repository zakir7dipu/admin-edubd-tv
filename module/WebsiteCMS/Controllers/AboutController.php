<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\About;
use Module\WebsiteCMS\Models\AboutCount;
use Module\WebsiteCMS\Requests\AboutUpdateRequest;
use App\Traits\CheckPermission;

class AboutController extends Controller
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
        $this->hasAccess("about-view");

        $data['about']     = About::where('id', 1)->with('aboutCounts')->first();

        return view('about/index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */


    public function create()
    {
        //
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */


    public function store(Request $request)
    {
        //
    }



    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */




    public function edit($id)
    {
        //
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */


    public function update(AboutUpdateRequest $request, $id)
    {
        // dd($request->all());
        try {
            $request->validated();

            $about = About::find($id);

            DB::transaction(function () use ($request, $about) {

                $about->update([
                    'title'                     => $request->title,
                    'short_description'         => $request->short_description,
                    'image'                     => $about->image,
                    'background_image'          => $about->background_image,
                    'description'               => $request->description,

                ]);

                $this->uploadImage($request->image, $about, 'image','About/image', 450, 500);
                $this->uploadImage($request->background_image, $about, 'background_image', 'About/Background-image', 1050, 450);

                $about->aboutCounts()->delete();
                foreach($request->count_title ?? [] as $key => $title) {

                    $about->aboutCounts()->create([
                        'title'         => $title,
                        'count'         => $request->count[$key],

                    ]);
                }
            });

            return redirect()->route('wc.about.index')->withMessage('About has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.about.index')->withErrors($th->getMessage());
        }
    }






    /*
    |--------------------------------------------------------------------------
    | DESTROY (METHOD)
    |--------------------------------------------------------------------------
    */



    public function destroy($id)
    {
        //
    }
}
