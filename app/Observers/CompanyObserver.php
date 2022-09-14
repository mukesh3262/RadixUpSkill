<?php

namespace App\Observers;
use App\Models\Company;
use Mail;
use App\Mail\SendMail;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function created(Company $company)
    {
        try{
            $subject = "New Company Added";
            $view = "emails.all";

            $data['name'] = $company['name'];
            $data['body'] = "Congratulations !! You are Successfully Registered as ".$company['name'].".";
            Mail::to('mukesh.mali@radixweb.com')->send(new SendMail($data, $subject, $view));
            
        }catch(\Exception $e){
            return $e->getMessage();
        }
        

        // $subject = "New company added";
        // $view = "emails.all";
        // Mail::to($data['email'])->send(new SendMail($data, $subject, $view));

    }

    /**
     * Handle the Company "updated" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function updated(Company $company)
    {
        //
    }

    /**
     * Handle the Company "deleted" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function deleted(Company $company)
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function restored(Company $company)
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function forceDeleted(Company $company)
    {
        //
    }
}
