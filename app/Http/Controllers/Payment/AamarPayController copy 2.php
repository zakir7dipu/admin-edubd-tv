<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\EnrollmentSuccessfullyJob;
use Illuminate\Http\Request;
use App\Http\Middleware\VerifyCsrfToken;
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
            'store_id'      => 'edubd',
            'signature_key' => 'bd72b6045390e3523af2225c90144ea2',
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
        
        // dd( $fields);
        $fields_string = http_build_query($fields);
        // dd($fields_string);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, "https://secure.aamarpay.com/request.php");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
        curl_close($ch);
        
        
        /// zakir
        // $url = "https://secure.aamarpay.com/request.php";
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_ENCODING, '');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
        
        // $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // if ($httpcode === 200) {
        //     \Log::info("paymet successfull " . $invoice_no . ' ! ' . 'code:' . $httpcode);
        // } else {
        //     \Log::info("CURL-Errors: " . json_encode(curl_error($ch).'code:'.$httpcode));
        // }
        // curl_close($ch);

        $enrollment->update(['payment_tnx_no' => $trans_id, 'payment_status' => 'Due']);
                // dd($url_forward);

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
                        action="<?php echo  "https://secure.aamarpay.com" . $url; ?>"
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
        return redirect()->to("https://edubd.tv"."/enrollment-success/".$enrollment->invoice_no);
        // return  $request;
    }





    // public function fail(Request $request)
    // {
    //     return redirect()->to("https://edubd.tv/payment-failed");

    // }
    public function fail(Request $request){
        return redirect()->to("https://edubd.tv/payment-failed");
    }

    




    public function cancel()
    {
        return redirect()->to("https://edubd.tv/payment-failed");
    }
}
