<?php

namespace Module\ExamManagement\Controllers\API\V1;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use App\Http\Controllers\Controller;
use Module\ExamManagement\Models\ExamCategory;
use Module\ExamManagement\Resources\ExamCategoryResource;

class ExamCategoryController extends Controller
{
    // public function childExamCategories($parent_id)
    // {
    //     return  ExamCategory::query()
    //             ->active()
    //             ->serialNoAsc()
    //             ->where('parent_id', $parent_id)
    //             ->with('exams')
    //             ->get()
    //             ->map(function ($item) {
    //                 return [
    //                     'id'                => $item->id,
    //                     'parentId'          => $item->parent_id,
    //                     'name'              => $item->name,
    //                     'slug'              => $item->slug,
    //                     'childCategories'   => $this->childExamCategories($item->id),
    //                 ];
    //             });
    // }



    // public function examCategories()
    // {
    //     try {
    //         $categories = ExamCategory::query()
    //                     ->active()
    //                     ->serialNoAsc()
    //                     ->where('parent_id', null)
    //                     ->with('exams')
    //                     ->get()
    //                     ->map(function ($item) {
    //                         return [
    //                             'id'                => $item->id,
    //                             'parentId'          => $item->parent_id,
    //                             'name'              => $item->name,
    //                             'slug'              => $item->slug,
    //                             'childCategories'   => $this->childExamCategories($item->id),
    //                         ];
    //                     });

    //         return  response()->json([
    //                     'status'    => 1,
    //                     'message'   => count($categories) == 0 ? 'No items found!' : 'Success!',
    //                     'data'      => $categories,
    //                     'errors'    => null
    //                 ]);

    //     } catch (\Throwable $th) {
    //         return  response()
    //                 ->json([
    //                     'status'    => 0,
    //                     'message'   => 'There was an error!',
    //                     'data'      => null,
    //                     'error'     => $th->getMessage()
    //                 ]);
    //     }
    // }





    /*
    |--------------------------------------------------------------------------
    | PARENT EXAM CATEGORIES (METHOD)
    |--------------------------------------------------------------------------
    */
    public function parentExamCategories()
    {
        try {
            $categories = ExamCategoryResource::collection(
                            ExamCategory::query()
                                ->active()
                                ->serialNoAsc()
                                ->where('parent_id', null)
                                ->with('exams')
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
    | EXAM CATEGORIES BY PARENT (METHOD)
    |--------------------------------------------------------------------------
    */
    public function examCategoriesByParent($parent_id)
    {
        try {
            $categories = ExamCategoryResource::collection(
                            ExamCategory::query()
                                ->active()
                                ->serialNoAsc()
                                ->where('parent_id', $parent_id)
                                // ->when(request()->filled('exam_category_for_menu'), fn ($q) => $q->where('show_in_menu', 1))
                                ->with('exams')
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
}
