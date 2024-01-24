<?php

namespace Module\WebsiteCMS\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Module\WebsiteCMS\Models\Subscriber;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubscriberExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */


    public function headings():array{
        return[
            'Id',
            'Email',
            'Is Varified',
            'Status'
        ];
    }
    public function collection()
    {
        return Subscriber::select(['id', 'email','is_verified','status'])->get();
    }
}
