<?php

namespace App\Helper;

use Omnipay\Omnipay;
//use Omnipay\PayPal\Message\AbstractRequest;
use Log;
// use App\Model\Wallet;
use Auth;

/**
 * Description of PayPalHelper
 *
 * @author Bhupesh
 */
class PayPalHelper
{

    /**
     * return mixed
     */
    public function gateway($type = null)
    {

        $gateway = Omnipay::create('PayPal_Rest');

        $gateway->setClientId(config('constant.paypal.PAYPAL_CLIENT_ID'));
        $gateway->setSecret(config('constant.paypal.PAYPAL_CLIENT_SECRET'));

        $gateway->setTestMode(config('constant.paypal.PAYPAL_TEST_MODE'));

        Log::info('<------------- $gateway->getToken() ------------->');
        $token = $gateway->getToken(true);
        Log::info([$token]);

        Log::info('<------------- $gateway->getParameters() ------------->');
        Log::info([$gateway->getParameters()]);

        return $gateway;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function purchase(array $parameters)
    {
        Log::info('<------------- purchase->$parameters ------------->');
        Log::info([$parameters]);

        $parameters['currency'] = $this->getCurrency();
        $response = $this->gateway()
            ->purchase($parameters)
            ->send();
        // dd($response);
        /*  $response->setData()=$arr;
          dd($response->getData());*/


        Log::info('<------------- purchase->$response ------------->');
        Log::info([$response->getData()]);

        return $response;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function complete(array $parameters)
    {
        $response = $this->gateway()
            ->completePurchase($parameters)
            ->send();
        $this->getTransactionDetails($response);
        return $response;
    }

    /**
     * @param $amount
     * @return float
     */
    public function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * @param $order
     * @return string
     */
    public function getCancelUrl()
    {
        return route('paypal.checkout.cancelled');
    }

    /**
     * @param $order
     * @return string
     */
    public function getReturnUrl()
    {
        return route('paypal.checkout.completed');
    }

    /**
     * @param $order
     * @return string
     */
    public function getNotifyUrl($order)
    {
        $env = config('constant.paypal.PAYPAL_SANDBOX') === true ? "sandbox" : "live";

        return route('webhook.paypal.ipn', [$order->id, $env]);
    }

    /**
     * Get currency
     * @return string
     */
    public function getCurrency()
    {
        return config('constant.paypal.PAYPAL_CURRENCY', 'USD');
    }

    /*
     * Get transactions Details
     * @store details
     */
    public function getTransactionDetails($request)
    {
        $transactionRefrence = $request->getTransactionReference();

        if($transactionRefrence != NULL){
            $invoice = $request->getData()['transactions'][0]['invoice_number'];
            if ($request->getData()) {
                $paypalfee = $request->getData()['transactions'][0]['related_resources'][0]['sale']['transaction_fee']['value'];

                // $wallet = Wallet::where('transaction_id', $invoice)->update([
                //     'transaction_reference' => $transactionRefrence,
                //     'paypal_fee' => $paypalfee,
                // ]);
            }
       }

      return $transactionRefrence;

    }

}
