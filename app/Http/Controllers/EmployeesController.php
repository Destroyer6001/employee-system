<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeesController extends Controller
{
    
    public function index()
    {
        $employees = Employees::with('RelationStalls')->get();
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'FirstName' => 'required|string|max:100',
            'LastName' => 'required|string|max:100',
            'Email' => 'required|email|max:150|unique:employees,Email',
            'Phone' => 'string',
            'Stall_id' => 'required'
        ]); 

        if($validation->fails())
        {
            return response()->json([
                'Errors' => $validation->errors()
            ],422);
        }

        $employee = new Employees();
        $employee->FirstName = $request->FirstName;
        $employee->LastName = $request->LastName;
        $employee->Email = $request->Email;
        $employee->Phone = $request->Phone;
        $employee->Stall_id = $request->Stall_id;
        $employee->save();

        $data = [
            'Message' => 'Employees created succesfull',
            'Employee' => $employee
        ];

        return response()->json($data);
    }
    
   
  
    public function show(Employees $employees)
    {
        return response()->json($employees);
    }

    public function update(Request $request, Employees $employees)
    {
        $validation = Validator::make($request->all(),[
            'FirstName' => 'required|string|max:100',
            'LastName' => 'required|string|max:100',
            'Phone' => 'string',
            'Stall_id' => 'required',
            'Email' => [
                'required',
                'string',
                'max:150',
                Rule::unique('employees')->ignore($employees->id)
            ]
        ]);

        if($validation->fails())
        {
            return response()->json(['Errors' => $validation->errors()],422);
        }

        $employees->FirstName = $request->FirstName;
        $employees->LastName = $request->LastName;
        $employees->Phone = $request->Phone;
        $employees->Email = $request->Email;
        $employees->Stall_id = $request->Stall_id;
        $employees->save();

        $data = [
            'Message' => 'Employee update successfull',
            'Employee' => $employees
        ];

        return response()->json($data);
    }


    public function destroy(Employees $employees)
    {
        $employees->delete();
        $data = [
            'Message' => 'Employee delete successfull',
            'Employee' => $employees
        ];

        return response()->json($data);
    }
}
