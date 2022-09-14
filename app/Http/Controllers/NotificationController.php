<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    public function index(){
        return view('admin.notification.add');
    }

    public function saveToken(Request $request){
        dd($request->all());
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

    public function sendNotification(Request $r){

        try {
            // Validate request (Using named arguments)
            $validator = validate(
                inputs: $r->all(),
                rules: [
                    "title" => "required|max:25",
                    "body" => "required|max:50"
                ],
                attributes: [
                    "title" => "Notification title",
                    "body" => "Notification body"
                ]
            );
    
            if(!empty($validator)) {
                return error($validator);
            }

            $FCM_URL = env("FCM_URL");

            $FCM_Tokens = User::whereNotNull('device_token')->pluck('device_token')->all();
            $FCM_SERVER_KEY = env("FCM_SERVER_KEY");
    
            $data = [
                "registration_ids" => $FCM_Tokens,
                "notification" => [
                    "title" => $r->title,
                    "body" => $r->body,  
                ]
            ];
            $encodedData = json_encode($data);
        
            $headers = [
                'Authorization:key=' . $FCM_SERVER_KEY,
                'Content-Type: application/json',
            ];
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $FCM_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                dd("FCM notification is failed to send!", curl_error($ch));
                return error("FCM notification is failed to send!", curl_error($ch));
            }        
            // Close connection
            curl_close($ch);
            // FCM response
            dd("Notification sent successfully!", $result);

            return success("Notification sent successfully!", $result);
        } catch (Exception $e) {
            return $e;
        }
    }
}
