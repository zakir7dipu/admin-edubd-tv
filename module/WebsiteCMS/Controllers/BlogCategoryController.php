<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\PageUpdateRequest;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\BlogCategory;
use Module\WebsiteCMS\Models\Page;
use Module\WebsiteCMS\Requests\BlogCategoryStoreRequest;
use Module\WebsiteCMS\Requests\BlogCategoryUpdateRequest;
use App\Traits\CheckPermission;

class BlogCategoryController extends Controller
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

        $data['blogCategories']    = BlogCategory::query()
                                                   ->where('name', 'like', '%' . request('search') . '%')
                                                   ->orWhere('slug', 'like', '%' . request('search') . '%')
                                                   ->with('blog:id')
                                                   ->withCount(['blog as totalBlog'])
                                                   ->paginate(20);

        $data['table']              = BlogCategory::getTableName();

        return view('blog-category/index', $data);
    }






/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/

    public function create()
    {
        $data['nextSerialNo']         = nextSerialNo(BlogCategory::class);

        return view('blog-category/create', $data);
    }






/*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/


    public function store(BlogCategoryStoreRequest $request)
    {
        try {
            $request->validated();
            DB::transaction(function () use ($request) {


               BlogCategory::create([
                    'name'                  => $request->name,
                    'slug'                  => $request->slug,
                    'serial_no'             => $request->serial_no,
                    'status'                => $request->status ?? 0,
                ]);

            });

            return redirect()->route('wc.blog-category.index')->withMessage('Blog Category has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.blog-category.index')->withErrors($th->getMessage());
        }
    }





/*
|--------------------------------------------------------------------------
| EDIT METHOD
|--------------------------------------------------------------------------
*/



     public function edit($id)
       {
           $data['blogCategory']      = BlogCategory::find($id);

           return view('blog-category/edit', $data);
       }





/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
    public function update(BlogCategoryUpdateRequest $request, BlogCategory $blogCategory)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $blogCategory) {

                $blogCategory->update([
                    'name'                  => $request->name,
                    'slug'                  => $request->slug,
                    'serial_no'             => $request->serial_no,
                    'status'                => $request->status ?? 0,
                ]);


            });

            return redirect()->route('wc.blog-category.index')->withMessage('Blog Category has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('wc.blog-category.index')->withErrors($th->getMessage());
        }
    }





    

/*
|--------------------------------------------------------------------------
| DESTROY (METHOD)
|--------------------------------------------------------------------------
*/
    public function destroy(BlogCategory $blogCategory)
    {
        try {
            DB::transaction(function () use ($blogCategory) {

                $blogCategory->delete();
            });

            return redirect()->route('wc.blog-category.index')->withMessage('Blog Category has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Blog Category');
        }
    }
}
