<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqsStoreRequest;
use App\Http\Requests\FaqsUpdateRequest;

use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\FAQ;
use App\Traits\CheckPermission;


class FaqsController extends Controller
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
        $this->hasAccess("faq-view");

        $data['faqs']    = FAQ::query()
                                ->where('title', 'like', '%' . request('search') . '%')
                                ->orWhere('description', 'like', '%' . request('search') . '%')
                                ->paginate(20);
        $data['table']      = FAQ::getTableName();

        return view('faqs/index', $data);
    }







/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/

    public function create()
    {
        $this->hasAccess("faq-create");

        $data['nextSerialNo'] = nextSerialNo(FAQ::class);

        return view('faqs/create', $data);
    }







/*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/



    public function store(FaqsStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {

                $faq = FAQ::create([
                    'title'                 => $request->title,
                    'description'           => $request->description,
                    'serial_no'             => $request->serial_no,
                    'status'                => $request->status ?? 0,
                ]);

            });

            return redirect()->route('wc.faqs.index')->withMessage('Faqs has been created successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('wc.faqs.index')->withErrors($th->getMessage());
        }
    }





    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("faq-edit");

        $data['faq']    = FAQ::find($id);

        return view('faqs/edit', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(FaqsUpdateRequest $request, FAQ $faq)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $faq) {

                $faq->update([
                    'title'                 => $request->title,
                    'description'           => $request->description,
                    'serial_no'             => $request->serial_no,
                    'status'                => $request->status ?? 0,
                ]);

            });

            return redirect()->route('wc.faqs.index')->withMessage('Faq has been updated successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('wc.faqs.index')->withErrors($th->getMessage());
        }
    }





    /*
    |--------------------------------------------------------------------------
    | DESTROY (METHOD)
    |--------------------------------------------------------------------------
    */
    public function destroy(FAQ $faq)
    {
        try {
            DB::transaction(function () use ($faq) {



                $faq->delete();
            });

            return redirect()->route('wc.faqs.index')->withMessage('Faqs has been deleted successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Faqs');
        }
    }
}
