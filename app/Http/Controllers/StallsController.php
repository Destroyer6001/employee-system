<?php

namespace App\Http\Controllers;

use App\Models\Stalls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StallsController extends Controller
{
    
    public function index()
    {
        $stalls = Stalls::all();
        return response()->json($stalls);
    }


    public function store(Request $request)
    {
        $validation =  Validator::make($request->all(),[
            'Name' => 'required|string|max:100|unique:stalls,Name'
        ]);

        if($validation->fails())
        {
            return response()->json([
                'Errors' => $validation->errors()
            ],422);
        }

        $stall = new Stalls();
        $stall->Name = $request->Name;
        $stall->save();

        $data = [
            'Message' => 'Stall create succesfull',
            'Stall' => $stall
        ];

        return response()->json($data);
    }


    public function show(Stalls $stalls)
    {
        return response()->json($stalls);
    }

 
    public function update(Request $request, Stalls $stalls)
    {
        $validation = Validator::make($request->all(),[
            'Name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('stalls')->ignore($stalls->id)
            ]
        ]);

        if($validation->fails())
        {
            return response()->json(['Errors' => $validation->errors()],422);
        }

        $stalls->Name = $request->Name;
        $stalls->save();
        $data = [
            'Message' => 'Stall upgrate succesfull',
            'Stall' => $stalls
        ];

        return response()->json($data);
    }


    public function destroy(Stalls $stalls)
    {
        $stalls->delete();
        $data = [
            'Message' => 'Stall delete succesfull',
            'Stall' => $stalls
        ];

        return response()->json($data);
    }
}
