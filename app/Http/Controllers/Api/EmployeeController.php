<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
use App\Models\Employee;
use App\Http\Resources\Employee as EmployeeResource;
use App\Models\Company;


class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::with('company')->get();
        return $this->sendResponse(EmployeeResource::collection($employee), 'Employee retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employee',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'company_id' => 'required|integer'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $checkCompany = Company::where('id',$input['company_id'])->first();
        if(!$checkCompany){
            return $this->sendError('Company not exists');       
        }
      
        $input['password'] = bcrypt($input['password']);
        $employee = Employee::create($input);
   
        return $this->sendResponse(new EmployeeResource($employee), 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        if (is_null($employee)) {
            return $this->sendError('Employee not found.');
        }
        return $this->sendResponse(new EmployeeResource($employee), 'Employee retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employee',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'company_id' => 'required|integer'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $checkCompany = Company::where('id',$input['company_id'])->first();
        if(!$checkCompany){
            return $this->sendError('Company not exists');       
        }
        
        $employee = Employee::find($id);
        $employee->first_name = $input['first_name'];
        $employee->last_name = $input['last_name'];
        $employee->email = $input['email'];
        $employee->password = bcrypt($input['password']);
        $employee->company_id = $input['company_id'];
        $employee->save();
   
        return $this->sendResponse(new EmployeeResource($employee), 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Employee::where('id', $id)->firstorfail()->delete();
        }
        catch(\Exception $e){
            return $this->sendError('Employee not found.');
        }

        return $this->sendResponse([], 'Employee deleted successfully.');
    }
}
