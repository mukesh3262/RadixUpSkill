<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\MyFacade;
use Mail;
use App\Mail\SendMail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function facadesView(){
        return view('admin.facades.add');
    }

    public function getSlug(Request $request){
        $slug = MyFacade::slugify($request->text);
        return response()->json(array('success' => true,'data' => $slug));
    }

    public function qrCode(){
        return view('admin.qrcode.qrCode');
    }

    public function sendMail(){

        $data = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];

        $subject = "Test Mail";
        Mail::to('mukesh.mali@radixweb.com')->send(new SendMail($data, $subject));
           
        dd("Email is sent successfully.");
    }

    public function sendMailChimp(Request $request){
        dd('In mailchimp');

        $listId = env('MAILCHIMP_LIST_ID');
        $mailchimp = new \Mailchimp(env('MAILCHIMP_KEY'));

        $campaign = $mailchimp->campaigns->create('regular', [
            'list_id' => $listId,
            'subject' => 'Example Mail',
            'from_email' => 'mukesh.mali@radixweb.com',
            'from_name' => 'Rajesh',
            'to_name' => 'Rajesh Subscribers'

        ], [
            'html' => $request->input('content'),
            'text' => strip_tags($request->input('content'))
        ]);

        //Send campaign
        $mailchimp->campaigns->send($campaign['id']);

        dd('Campaign send successfully.');
    }
    

}
