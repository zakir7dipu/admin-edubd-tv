<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Blog;
use Module\WebsiteCMS\Models\BlogCategory;
use Module\WebsiteCMS\Requests\BlogStoreRequest;
use Module\WebsiteCMS\Requests\BlogUpdateRequest;
use App\Traits\CheckPermission;

class BlogController extends Controller
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
        $this->hasAccess("blog-view");

        $data['blogs']              = Blog::query()
                                            ->searchByField('category_id')
                                            ->where('title', 'like', '%' . request('search') . '%')
                                            ->orWhere('short_description', 'like', '%' . request('search') . '%')
                                            ->with('blogCategory')
                                            ->paginate(20);
        $data['blogCategories']     = BlogCategory::pluck('name', 'id');
        $data['table']              = Blog::getTableName();

        return view('blog/index', $data);
    }





/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/


    public function create()
    {
        $this->hasAccess("blog-crate");

        $data['blogCategories']      = BlogCategory::all();
        $data['nextSerialNo']        = nextSerialNo(Blog::class);

        return view('blog/create', $data);
    }





/*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/



    public function store(BlogStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {
                $blogCategory = $request->blogCategory;
                // dd($blogCategory);
                $blog = Blog::create([
                    'category_id'              => $blogCategory,
                    'title'                    => $request->title,
                    'slug'                     => $request->slug,
                    'thumbnail_image'          => 'thumbnail_default.png',
                    'cover_image'              => 'cover_default.png',
                    'short_description'        => $request->short_description,
                    'description'              => $request->description,
                    'serial_no'                => $request->serial_no,
                    'status'                   => $request->status ?? 0,
                ]);

                $this->uploadImage($request->thumbnail_image, $blog, 'thumbnail_image', 'blog/thumbnail_image', 300, 300);
                $this->uploadImage($request->cover_image, $blog, 'cover_image', 'blog/cover_image', 1050, 450);
            });

            return redirect()->route('wc.blog.index')->withMessage('Blog has been created successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('wc.blog.index')->withErrors($th->getMessage());
        }
    }



    /*
|--------------------------------------------------------------------------
| EDIT METHOD
|--------------------------------------------------------------------------
*/

    public function edit($id)
    {
        $this->hasAccess("blog-edit");
        $data['blog']               = Blog::find($id);
        $data['blogCategories']     = BlogCategory::all();


        return view('blog/edit', $data);
    }





/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/

    public function update(BlogUpdateRequest $request, Blog $blog)
    {
        try {
            $request->validated();


            DB::transaction(function () use ($request, $blog) {
                $blogCategory = $request->blogCategory;
                $blog->update([
                    'category_id'           => $blogCategory,
                    'title'                 => $request->title,
                    'slug'                  => $request->slug,
                    'thumbnail_image'       => $blog->thumbnail_image,
                    'cover_image'           => $blog->cover_image,
                    'short_description'     => $request->short_description,
                    'description'           => $request->description,
                    'serial_no'             => $request->serial_no,
                    'status'                => $request->status ?? 0,
                ]);

                $this->uploadImage($request->thumbnail_image, $blog, 'thumbnail_image', 'blog/thumbnail_image', 300, 300);
                $this->uploadImage($request->cover_image, $blog, 'cover_image', 'blog/cover_image', 1050, 450);


            });

            return redirect()->route('wc.blog.index')->withMessage('Blog has been updated successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('wc.blog.index')->withErrors($th->getMessage());
        }
    }





/*
|--------------------------------------------------------------------------
| DELETE METHOD
|--------------------------------------------------------------------------
*/


    public function destroy(Blog $blog)
    {
        try {
            DB::transaction(function () use ($blog) {

                if (file_exists($blog->thumbnail_image || $blog->cover_image)) {
                    unlink($blog->thumbnail_image && $blog->cover_image);
                }

                $blog->delete();
            });

            return redirect()->route('wc.blog.index')->withMessage('Blog has been deleted successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this blog');
        }
    }
}
