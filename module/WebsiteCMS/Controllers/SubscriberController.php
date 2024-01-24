<?php

namespace Module\WebsiteCMS\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Exports\SubscriberExport;
use Module\WebsiteCMS\Models\Subscriber;
use App\Traits\CheckPermission;

class SubscriberController extends Controller
{
    use CheckPermission;

/*
|--------------------------------------------------------------------------
| INDEX METHOD
|--------------------------------------------------------------------------
*/
    public function index()
    {
        $this->hasAccess("subscriber-view");

        $data['subscribers']    = Subscriber::query()
                                                // ->where('name', 'like', '%' . request('search') . '%')
                                                // ->orWhere('designation', 'like', '%' . request('search') . '%')
                                                // ->orWhere('country', 'like', '%' . request('search') . '%')
                                                ->paginate(20);
        $data['table']           = Subscriber::getTableName();

        return view('subscriber/index', $data);
    }




/*
|--------------------------------------------------------------------------
| DESTROY (METHOD)
|--------------------------------------------------------------------------
*/
    public function destroy(Subscriber $subscriber)
    {
        try {
            DB::transaction(function () use ($subscriber) {


                $subscriber->delete();
            });

            return redirect()->route('wc.subscribers.index')->withMessage('Subscriber has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Subscriber');
        }
    }


    public function Export()
    {
        return Excel::download(new SubscriberExport, 'subscriber.xlsx');
    }
}
