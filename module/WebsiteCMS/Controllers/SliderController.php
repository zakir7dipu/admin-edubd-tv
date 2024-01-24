<?php

namespace Module\WebsiteCMS\Controllers;

use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\CourseManagement\Models\Course;
use Module\WebsiteCMS\Models\Slider;
use Module\WebsiteCMS\Requests\SliderStoreRequest;
use Module\WebsiteCMS\Requests\SliderUpdateRequest;
use App\Traits\CheckPermission;

class SliderController extends Controller
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
        $this->hasAccess("slider-view");

        $data['sliders']    = Slider::query()
                            ->where('title', 'like', '%' . request('search') . '%')
                            ->orWhere('short_description', 'like', '%' . request('search') . '%')
                            ->idDesc()
                            ->paginate(20);

        $data['table']      = Slider::getTableName();
        // dd($data['sliders']);

        return view('slider/index', $data);
    }





/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/
    public function create()
    {
        $this->hasAccess("slider-create");

        $data['courses']                = Course::where('is_slider', 1)->pluck('title', 'id');
        $data['nextSerialNo']           = nextSerialNo(Slider::class);
// dd($data['courses']);
        return view('slider/create', $data);
    }





/*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/
    public function store(SliderStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {

                $slider = Slider::create([
                    'course_id'             =>$request->course_id,
                    'title'                 => $request->title,
                    'short_description'     => $request->short_description,
                    'image'                 => 'default.png',
                    'link'                  => $request->link,
                    'serial_no'             => $request->serial_no,
                    'status'                => $request->status ?? 0,
                ]);

                $this->uploadImage($request->image, $slider, 'image', 'slider', 1050, 450);
            });

            return redirect()->route('wc.sliders.index')->withMessage('Slider has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.sliders.index')->withErrors($th->getMessage());
        }
    }





/*
|--------------------------------------------------------------------------
| EDIT METHOD
|--------------------------------------------------------------------------
*/
    public function edit($id)
    {
        $this->hasAccess("slider-edit");

        $data['slider'] = Slider::find($id);
        $data['courses']       = Course::pluck('title', 'id');

        return view('slider/edit', $data);
    }







/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
    public function update(SliderUpdateRequest $request, Slider $slider)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $slider) {

                $slider->update([
                    'course_id'             =>$request->course_id,
                    'title'                 => $request->title,
                    'short_description'     => $request->short_description,
                    'image'                 => $slider->image,
                    'link'                  => $request->link,
                    'serial_no'             => $request->serial_no,
                    'status'                => $request->status ?? 0,
                ]);

                $this->uploadImage($request->image, $slider, 'image', 'slider', 1050, 450);
            });

            return redirect()->route('wc.sliders.index')->withMessage('Slider has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.sliders.index')->withErrors($th->getMessage());
        }
    }





/*
|--------------------------------------------------------------------------
| DESTROY (METHOD)
|--------------------------------------------------------------------------
*/
    public function destroy(Slider $slider)
    {
        try {
            DB::transaction(function () use ($slider) {

                if(file_exists($slider->image)) {
                    unlink($slider->image);
                }

                $slider->delete();
            });

            return redirect()->route('wc.sliders.index')->withMessage('Slider has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Slider');
        }
    }


    // extra
    public function getCourse(Request $request){

        $data['courses'] = Course::where('id', $request->id)->first();
        // Fetch all records
        // $response['data'] = $course_list;

        return response()->json($data);
      }
}
