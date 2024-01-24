<?php

use Illuminate\Support\Str;





/*
|--------------------------------------------------------------------------
| ENROLLMENT INVOICE NO (METHOD)
|--------------------------------------------------------------------------
*/
function enrollmentInvoiceNo()
{
    return 'EduTv' . date('y') . auth()->id() . '-' . Str::upper(Str::random(8));
}