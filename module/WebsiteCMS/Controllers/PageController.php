<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Page;
use Module\WebsiteCMS\Models\Slider;
use App\Traits\CheckPermission;

class PageController extends Controller
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
        $this->hasAccess("page-view");

        $data['pages']    = Page::query()
                                  ->where('name', 'like', '%' . request('search') . '%')
                                  ->orWhere('slug', 'like', '%' . request('search') . '%')
                                  ->orWhere('description', 'like', '%' . request('search') . '%')

                                  ->paginate(20);
        $data['table']      = Page::getTableName();

        return view('pages/index', $data);
    }







/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/
    public function create()
    {
        $this->hasAccess("page-create");

        $data['nextSerialNo'] = nextSerialNo(Page::class);

        return view('pages/create', $data);
    }







/*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/


    public function store(PageStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {

                $page = Page::create([
                    'name'                  => $request->name,
                    'slug'                  => $request->slug,
                    'description'           => $request->description,
                    'serial_no'             => $request->serial_no,
                    'position'              => $request->position,
                    'status'                => $request->status ?? 0,
                ]);

            });

            return redirect()->route('wc.pages.index')->withMessage('Page has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.pages.index')->withErrors($th->getMessage());
        }
    }





/*
|--------------------------------------------------------------------------
| EDIT METHOD
|--------------------------------------------------------------------------
*/
    public function edit($id)
    {
        $this->hasAccess("page-edit");

        $data['page'] = Page::find($id);

        return view('pages/edit', $data);
    }







/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
    public function update(PageUpdateRequest $request, Page $page)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $page) {

                $page->update([
                    'name'                  => $request->name,
                    'slug'                  => $request->slug,
                    'description'           => $request->description,
                    'serial_no'             => $request->serial_no,
                    'position'              => $request->position,
                    'status'                => $request->status ?? 0,
                ]);
            });

            return redirect()->route('wc.pages.index')->withMessage('Page has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.pages.index')->withErrors($th->getMessage());
        }
    }







/*
|--------------------------------------------------------------------------
| DESTROY (METHOD)
|--------------------------------------------------------------------------
*/


    public function destroy(Page $page)
    {
        try {
            DB::transaction(function () use ($page) {

                if(file_exists($page->image)) {
                    unlink($page->image);
                }
                if(file_exists($page->banner_image)) {
                    unlink($page->banner_image);
                }

                $page->delete();
            });

            return redirect()->route('wc.pages.index')->withMessage('Page has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Page');
        }
    }
}
