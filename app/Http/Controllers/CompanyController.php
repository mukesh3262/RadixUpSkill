<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Validator;
use App\Http\Requests\CompanyRequest;
use App\Traits\Imageable;
use DB;
use App;
use \Cache;


class CompanyController extends Controller
{
    use Imageable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang = "")
    {   
        if($lang){
            App::setlocale($lang);
        }
        
        $cachedCompany = Cache::get('company');
        if(isset($cachedCompany)){
            $company = json_decode($cachedCompany, FALSE);
        }else{
            $company = Company::with('employee')->get();
            Cache::put('company', $company);
        }
        return view('admin.company.list',compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.company.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request, Company $company)
    {
        if (request()->hasFile('image')) {
           $file =  $company->storeMedia($request);
        }
       
        // $comapany = New Company;
        // $comapany->name = $request->name;
        // $comapany->email = $request->email;
        // $comapany->website = $request->website;
        // $comapany->logo = isset($file) ? $file : NULL;
        // $comapany->save();

        $companyArray = array(
            'name'     =>  $request->name,
            'email'   =>   $request->email,
            'website'   =>   $request->website,
            'logo'   =>   isset($file) ? $file : NULL,
        );

        Cache::forget('company');
        Company::create($companyArray);
        // DB::table('company')->insert($companyArray);

        return redirect()->route('company.index')->with('success',"Company added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $company = Company::find($id);
        $company = DB::table('company')->where('id',$id)->first();
        return view('admin.company.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, CompanyRequest $req)
    {
        if (request()->hasFile('image')) {
            $file = $this->storeMedia($request);
        }
        // $comapany = Company::find($id);
        // $comapany->name = $request->name;
        // $comapany->email = $request->email;
        // $comapany->website = $request->website;
        // $comapany->logo = isset($file) ? $file : NULL;
        // $comapany->save();

        $companyArray = array(
            'name'     =>  $request->name,
            'email'   =>   $request->name,
            'website'   =>   $request->website,
            'logo'   =>   isset($file) ? $file : NULL,
        );

        Cache::forget('company');
        DB::table('company')
        ->where('id', $id)  
        ->update($companyArray);  

        return redirect()->route('company.index')->with('success',"Company updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Company::where('id', $id)->firstorfail()->delete();
        Cache::forget('company');
        DB::table('company')->where('id', $id)->delete();
        return redirect()->route('company.index')->with('success',"Company deleted successfully");
    }
}
