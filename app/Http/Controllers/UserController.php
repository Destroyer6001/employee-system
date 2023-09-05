<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create(Request $resquest)
    {
        $validation = Validator::make($resquest->all(),[
            'name' => 'required|string|max:100',
            'email' => 'required|email|string:50|unique:users,email',
            'password' => 'required|min:8'
        ]);

        if($validation->fails())
        {
            return response()->json([
                'Errors' => $validation->errors()
            ],422);
        }

        $user = new User();
        $user->name = $resquest->name;
        $user->email = $resquest->email;
        $user->password = Hash::make($resquest->password);
        $user->save();

        $data = [
            'Message' => 'User Created Succesfull',
            'User' => $user,
            'Token' => $user->createToken('API TOKEN')->plainTextToken
        ];

        return response()->json($data);
    }

    public function login(Request $resquest)
    {
        $validation = Validator::make($resquest->all(),[
            'email' => 'required|email|string:50',
            'password' => 'required|min:8'
        ]);

        if($validation->fails())
        {
            return response()->json([
                'Errors' => $validation->errors()
            ],422);
        }

        if(!Auth::attempt($resquest->only('email','password')))
        {
            return response()->json([
                'Errors' => ['Unathorized']
            ],401);
        }

        $user = User::where('email',$resquest->email)->first();

        $data = [
            'Message' => 'User logged in sucessfull',
            'User' => $user,
            'Token' => $user->createToken('API TOKEN')->plainTextToken
        ];

        return response()->json($data);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        $data = [
            'Message' => 'User Logged out Sucessfull'
        ];
        return response()->json($data);
    }
}
