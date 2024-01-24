<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ReportExport implements FromCollection
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        
        $employees = $this->getExportEmployeeData($this->request);

        return view('employee.export_employee',compact('employees'));
    }


    public function getExportEmployeeData($request)
    {
        $relation = ['company.group', 'created_user', 'updated_user', 'grade', 'shift',
                'educational_qualification', 'experience', 'personal_information', 'guardian', 'reference_person',
                'bank_information.company_bank'];

        return Employee::with($relation)->get();
    }

}
