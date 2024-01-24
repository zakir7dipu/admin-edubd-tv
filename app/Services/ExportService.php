<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;



class ExportService
{
    public function exportData($data, $file_path, $filename)
    {

        set_time_limit(0);

        if (request('export_type') == 'excel') {

            $data['file_path'] = $file_path;
            return Excel::download(new ExportExcelService($data), $filename . '.xlsx');
        }
    }
}
