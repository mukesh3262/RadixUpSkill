<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\PayPalHelper;

class PaypalController extends Controller
{
    public function index(){
        return view('admin.paypal.paypal');
    }

    public function checkout(Request $request){
        $amount = 100;
        $transaction_id = \Str::random(18); // random string for transaction id

        $paypal = new PayPalHelper;
        $response = $paypal->purchase([
            'amount' => $paypal->formatAmount($amount),
            'transactionId' => $transaction_id,
            'currency' => $paypal->getCurrency(),
            'cancelUrl' => $paypal->getCancelUrl(),
            'returnUrl' => $paypal->getReturnUrl(),
            'description' => "Amount Added",
        ]);
        // dd($response);
        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
                    'success' => $response->getMessage(),
        ]);
    }

    public function cancelled() {
        // $order = Wallet::findOrFail($order);
        return redirect()->route('paypal')->with('success', 'You have cancelled your recent PayPal payment !');
    }

    public function completed(Request $request) {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $paypal = new PayPalHelper;
            $response = $paypal->complete([
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ]);

            $abc = $paypal->getTransactionDetails($response);

            if ($response->isSuccessful()) {
                $this->afterPaymentComplete($response);
                return redirect()->route('paypal.checkout.success')->with([
                            'success' => 'You recent payment is sucessful with reference code ' . $response->getTransactionReference(),
                ]);
            }

            return redirect()->route('paypal.checkout.success')->with([
                        'success' => $response->getMessage(),
            ]);
        }
        return 'Transaction is declined';
    }

    public function success() {
        return view('admin.paypal.paypal');
    }

    public function afterPaymentComplete($response) {
        // Anything you want do here after complete payment

        // $arr_body = $response->getData(); // you are get the payer data here

        // $isPaymentExist = PaypalPayment::where('payment_id', $arr_body['id'])->first();

        // if (!$isPaymentExist) {
        //     $payment = new PaypalPayment;
        //     $payment->payment_id = $arr_body['id'];
        //     $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
        //     $payment->payer_email = $arr_body['payer']['payer_info']['email'];
        //     $payment->amount = $arr_body['transactions'][0]['amount']['total'];
        //     $payment->currency = env('PAYPAL_CURRENCY', 'USD');
        //     $payment->payment_status = $arr_body['state'];
        //     $payment->save();
        //     Log::info([$payment->toArray()]);
        // }

        // $orderId = $arr_body['transactions'][0]['invoice_number'];
        // $wallet = Wallet::where('order_id', $orderId)->first();
        // $wallet->status = Wallet::PAYMET_STATUS_COMPLETE;
        // $wallet->description = "Funds Added";
        // $wallet->transaction_id = $arr_body['id'];
        // $wallet->save();

        // $userDetails = Wallet::join('users', 'users.id', 'wallets.user_id')
        //                 ->select('wallets.*', 'users.name', 'users.email', 'users.email_verified_at', 'password', 'contact_no', 'remember_token', 'wallet')
        //                 ->where('wallets.id', $wallet->id)->first();

        // Log::info([$userDetails->toArray()]);
        // $mail = MailHelper::addFundAdminMail($userDetails);

        // Log::info([$wallet->toArray()]);

        return true;
    }
}
