<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderStoreRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Http\Requests\TestimonialsStoreRequest;
use App\Http\Requests\TestimonialsUpdateRequest;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Slider;
use Module\WebsiteCMS\Models\Testimonial;
use App\Traits\CheckPermission;

class TestimonialsController extends Controller
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
        $this->hasAccess("tstimonials-view");

        $data['testimonials']    = Testimonial::query()
                                                ->where('name', 'like', '%' . request('search') . '%')
                                                ->orWhere('designation', 'like', '%' . request('search') . '%')
                                                ->orWhere('country', 'like', '%' . request('search') . '%')
                                                ->paginate(20);
        $data['table']           = Testimonial::getTableName();

        return view('testimonials/index', $data);
    }







/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/


    public function create()
    {
        $this->hasAccess("tstimonials-create");

        $data['nextSerialNo'] = nextSerialNo(Testimonial::class);

        return view('testimonials/create', $data);
    }









/*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/


    public function store(TestimonialsStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {

                $testimonial = Testimonial::create([
                    'name'                  => $request->name,
                    'designation'           => $request->designation,
                    'country'               => $request->country,
                    'description'           => $request->description,
                    'image'                 => 'default.png',
                    'rating'                => $request->rating,
                    'serial_no'             => $request->serial_no,
                    'status'                => $request->status ?? 0,
                ]);

                $this->uploadImage($request->image, $testimonial, 'image', 'testimonials', 200, 200);
            });

            return redirect()->route('wc.testimonials.index')->withMessage('Testimonials has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.testimonials.index')->withErrors($th->getMessage());
        }
    }







/*
|--------------------------------------------------------------------------
| EDIT METHOD
|--------------------------------------------------------------------------
*/

    public function edit($id)
    {
        $this->hasAccess("tstimonials-edit");

        $data['testimonial'] = Testimonial::find($id);

        return view('testimonials/edit', $data);
    }







/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
    public function update(TestimonialsUpdateRequest $request, Testimonial $testimonial)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $testimonial) {

                $testimonial->update([
                    'name'                 => $request->name,
                    'designation'          => $request->designation,
                    'country'              => $request->country,
                    'description'          => $request->description,
                    'image'                => $testimonial->image,
                    'rating'               => $request->rating,
                    'serial_no'            => $request->serial_no,
                    'status'               => $request->status ?? 0,
                ]);

                $this->uploadImage($request->image, $testimonial, 'image', 'testimonials', 200, 200);
            });

            return redirect()->route('wc.testimonials.index')->withMessage('Testimonials has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.testimonials.index')->withErrors($th->getMessage());
        }
    }





/*
|--------------------------------------------------------------------------
| DESTROY (METHOD)
|--------------------------------------------------------------------------
*/
    public function destroy(Testimonial $testimonial)
    {
        try {
            DB::transaction(function () use ($testimonial) {

                if(file_exists($testimonial->image)) {
                    unlink($testimonial->image);
                }

                $testimonial->delete();
            });

            return redirect()->route('wc.testimonials.index')->withMessage('Testimonials has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Slider');
        }
    }
}
