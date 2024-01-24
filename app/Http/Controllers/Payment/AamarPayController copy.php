<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\EnrollmentSuccessfullyJob;
use Illuminate\Http\Request;
use Module\EnrollmentManagement\Models\Enrollment;

use Illuminate\Support\Str;

class AamarPayController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->invoice_no) {
            abort(404);
        }

        $invoice_no = decrypt($request->invoice_no);
        $enrollment = Enrollment::where('invoice_no', $invoice_no)->with('student')->first();

        if (!$enrollment) {
            abort(404);
        }

       $trans_id = optional($enrollment)->payment_tnx_no;

        $fields     = [
            'store_id'      => env('AAMARPAY_STORE_ID'),
            'signature_key' => env('AAMARPAY_SIGNATURE_KEY'),
            'amount'        => $enrollment->grand_total,
            'payment_type'  => 'VISA',
            'currency'      => 'BDT',
            'tran_id'       => $trans_id,
            'cus_name'      => optional($enrollment->student)->first_name . ' ' . optional($enrollment->student)->last_name,  //customer name
            'cus_email'     => optional($enrollment->student)->email,
            'cus_add1'      => optional($enrollment->student)->address_1,
            'cus_add2'      => optional($enrollment->student)->address_2,
            'cus_city'      => optional(optional($enrollment->student)->city)->name,
            'cus_state'     => optional(optional($enrollment->student)->state)->name,
            'cus_postcode'  => optional($enrollment->student)->postcode,
            'cus_country'   => optional(optional($enrollment->student)->country)->name,
            'cus_phone'     => optional($enrollment->student)->phone,
            'cus_fax'       => 'Not¬Applicable',
            'desc'          => 'payment description',
            'success_url'   => route('success'),
            'fail_url'      => route('fail'),
            'cancel_url'    => route('cancel'),
        ];

        $fields_string = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, env('AAMARPAY_REQUEST_URL'));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
        curl_close($ch);

        $enrollment->update(['payment_tnx_no' => $trans_id, 'payment_status' => 'Due']);
        $this->redirect_to_merchant($url_forward);
    }





    function redirect_to_merchant($url)
    {
        ?>
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <script type="text/javascript">
                    function closethisasap() { document.forms["redirectpost"].submit(); }
                </script>
            </head>
                <body onLoad="closethisasap();">
                    <form
                        name="redirectpost"
                        method="POST"
                        action="<?php echo env('AAMARPAY_URL') . '/' . $url; ?>"
                    >
                    </form>
                </body>
            </html>
        <?php
        exit;
    }





    public function success(Request $request)
    {

        $enrollment = Enrollment::where('payment_tnx_no', $request['mer_txnid'])->first();
        $enrollmentConfirmMail = [
            'email'     => $request->cus_email,
            'invoiceNo' => $enrollment->invoice_no
        ];
        $enrollment->update([
            'payment_status' => 'Paid',
            'payment_method' => $request->card_type,
        ]);
        // dispatch(new EnrollmentSuccessfullyJob($enrollmentConfirmMail));
        return redirect()->to(env('WEB_URL') . "/enrollment-success/" . $request['mer_txnid']);
        // return  $request;
    }





    public function fail(Request $request)
    {
        $name = 'rasel';
        return $name;
    }





    public function cancel()
    {
        return redirect()->to(env('WEB_URL') . "/payment-failed");
    }
}
