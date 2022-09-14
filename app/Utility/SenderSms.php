<?php

namespace App\Utility;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Utility\CommonHelper;
use App\AppSetting;

class SenderSms {

    //Username that is to be used for submission
    protected $strUserName;
    //password that is to be used along with username
    protected $strPassword;
    //Sender Id to be used for submitting the message
    protected $strSenderId;
    //Message content that is to be transmitted
    protected $strMessage;
    //Mobile No is to be transmitted
    protected $strMobile;
    // User Id
    protected $userId;

    /**
     * 
     * @param type $message
     * @param type $mobile
     * @param type $userId
     */
    public function __construct($message, $mobile, $userId) {
        $this->userId = $userId;
        $this->strMessage = $message;
        $this->strMobile = $mobile;

        $commonHelper = new CommonHelper();
        $userAppSetting = $commonHelper->getAppSetting($this->userId);
        $this->strUserName = '';
        $this->strPassword = '';
        $this->strSenderId = '';
        if (isset($userAppSetting['str_otp']) && $userAppSetting['str_otp'] == true) {
            $this->strUserName = isset($userAppSetting['sms_username']) ? $userAppSetting['sms_username'] : '';
            $this->strPassword = isset($userAppSetting['sms_password']) ? $userAppSetting['sms_password'] : '';
            $this->strSenderId = isset($userAppSetting['sms_sender_id']) ? $userAppSetting['sms_sender_id'] : '';
        }
    }

    /**
     * Set value in all parameters
     *
     * @return void
     */
    /* public function SenderSms($message, $mobile)
      {
      //dd('aaa', $message, $mobile);
      $this->strMessage = $message; //URL Encode The Message
      $this->strMobile = $mobile;
      } */

    /**
     * Send Sms to given mobile number
     *
     * @return string
     */
    public function Submit() {
        try {
            $url = "https://www.smsidea.co.in/smsstatuswithid.aspx";

            $fields = array(
                'mobile' => $this->strUserName,
                'pass' => $this->strPassword,
                'senderid' => $this->strSenderId,
                'to' => $this->strMobile,
                'msg' => urlencode($this->strMessage)
            );

            $fields_string = "";
            //url-ify the data for the POST
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }

            rtrim($fields_string, '&');

            //open connection
            $ch = curl_init();
            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //execute post
            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            //dd( $result, strpos($result, 'error') );

            if (strpos($result, 'error') !== false) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            //echo 'Message:' .$e->getMessage();
            return false;
        }
    }

}