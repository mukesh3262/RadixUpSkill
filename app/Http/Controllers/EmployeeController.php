<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Traits\Imageable;
use App\Models\Company;
use Mail;
use App\Mail\SendMail;
use App;
use \Cache;
use App\Events\EmployeeEvent;

class EmployeeController extends Controller
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

        $cachedEmployee = Cache::get('employee');

        if(isset($cachedEmployee)){
            $employee = json_decode($cachedEmployee, FALSE);
        }else{
            $employee = Employee::with('company')->get();
            Cache::put('employee', $employee);
        }
        
        return view('admin.employee.list',compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::all();
        return view('admin.employee.add',compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $data['company_id'] = $request->company;

        Cache::forget('employee');
        Employee::create($data);




        $subject = "New Employee Registration";
        $view = "emails.all";
        $data['body'] = "Congratulations !! You are Successfully Registered in Radixweb.";

        event(new EmployeeEvent($data, $subject, $view));


        return redirect()->route('emp.index')->with('success',"Employee added successfully");

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
        
        $employee = Employee::find($id);
        $company = Company::all();
        return view('admin.employee.edit',compact('employee','company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id , EmployeeRequest $req)
    {
        Cache::forget('employee');
        $employee = Employee::find($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company;
        $employee->save();

        return redirect()->route('emp.index')->with('success',"Employee updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cache::forget('employee');
        Employee::where('id', $id)->firstorfail()->delete();
        return redirect()->route('emp.index')->with('success',"Employee deleted successfully");
    }
}
