<?php

namespace Module\CourseManagement\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\CourseManagement\Models\CourseCategory;
use Module\CourseManagement\Resources\CourseCategoryResource;
use Module\CourseManagement\Resources\ShowInMenuCourseCategoryResource;

class CourseCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HIGHLIGHTED COURSE CATEGORIES (METHOD)
    |--------------------------------------------------------------------------
    */
    public function highlightedCourseCategories()
    {
        try {
            $categories = CourseCategoryResource::collection(
                            CourseCategory::query()
                                ->active()
                                ->highlighted()
                                ->serialNoDesc()
                                ->take(20)
                                ->get()
                        )
                        ->response()
                        ->getData(true);

            return  response()->json([
                        'status'    => 1,
                        'message'   => count($categories) == 0 ? 'No items found!' : 'Success!',
                        'data'      => $categories,
                        'errors'    => null
                    ]);

        } catch (\Throwable $th) {
            return  response()
                    ->json([
                        'status'    => 0,
                        'message'   => 'There was an error!',
                        'data'      => null,
                        'error'     => $th->getMessage()
                    ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW IN MENU PARENT COURSE CATEGORIES (METHOD)
    |--------------------------------------------------------------------------
    */
    public function showInMenuParentCourseCategories()
    {
        try {
            $categories = ShowInMenuCourseCategoryResource::collection(
                            CourseCategory::query()
                                ->active()
                                ->showInMenu()
                                ->serialNoDesc()
                                ->where('parent_id', null)
                                ->take(5)
                                ->get()
                        )
                        ->response()
                        ->getData(true);

            return  response()->json([
                        'status'    => 1,
                        'message'   => count($categories) == 0 ? 'No items found!' : 'Success!',
                        'data'      => $categories,
                        'errors'    => null
                    ]);

        } catch (\Throwable $th) {
            return  response()
                    ->json([
                        'status'    => 0,
                        'message'   => 'There was an error!',
                        'data'      => null,
                        'error'     => $th->getMessage()
                    ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW IN MENU COURSE CATEGORIES BY PARENT (METHOD)
    |--------------------------------------------------------------------------
    */
    public function showInMenuByParentCourseCategories($parent_id)
    {
        try {
            $categories = ShowInMenuCourseCategoryResource::collection(
                            CourseCategory::query()
                                ->active()
                                ->showInMenu()
                                ->serialNoDesc()
                                ->where('parent_id', $parent_id)
                                ->take(20)
                                ->get()
                        )
                        ->response()
                        ->getData(true);

            return  response()->json([
                        'status'    => 1,
                        'message'   => count($categories) == 0 ? 'No items found!' : 'Success!',
                        'data'      => $categories,
                        'errors'    => null
                    ]);

        } catch (\Throwable $th) {
            return  response()
                    ->json([
                        'status'    => 0,
                        'message'   => 'There was an error!',
                        'data'      => null,
                        'error'     => $th->getMessage()
                    ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW (METHOD)
    |--------------------------------------------------------------------------
    */
    public function show($slug)
    {
        try {
            $category   = CourseCategory::query()
                        ->where('slug', $slug)
                        ->select('id', 'parent_id', 'name', 'slug', 'short_description', 'serial_no', 'status')
                        ->first();

            return  response()->json([
                        'status'    => 1,
                        'message'   => 'Success!',
                        'data'      => $category,
                        'errors'    => null
                    ]);

        } catch (\Throwable $th) {
            return  response()
                    ->json([
                        'status'    => 0,
                        'message'   => 'There was an error!',
                        'data'      => null,
                        'error'     => $th->getMessage()
                    ]);
        }
    }
}
