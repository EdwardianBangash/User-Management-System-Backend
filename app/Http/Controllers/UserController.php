<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    public function index(){
        $user = User::all();
        return response()->json(array('data' => $user));
    }

    public function countUser(){
        $user = User::get();
        return response()->json(array('totalUser' => $user->count()));
    }

    public function addUser(Request $request){
     
        $validator = Validator::make($request->all(), [
            'fullname'=>'required|string',
            'email'=>'required|string|email',
            'address'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response(['error' => "All fields are required"], 422);
        }

        $user = '';

        $user = User::where('email', $request->email)->first();

        if($user){
            return response()->json(['error'=>'Email already taken.'], 500);
        }

        $user = new User();

        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->address = $request->address;

        $success = $user->save();

        if($success){
            return response()->json(['success'=>'User added successfully'], 200);
        }else{
            return response()->json(['error'=>'Failed to add user.'], 500);
        }
    }

    public function updateUser(Request $request){

        $validator = Validator::make($request->all(), [
            'fullname'=>'required|string',
            'email'=>'required|string|email',
            'address'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response(['error' => "All fields are required"], 422);
        }
        $user = User::find($request->id);

        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->address = $request->address;

        $success = $user->save();

        if($success){
            return response()->json(['success'=>'Data Updated Successfully'], 200);
        }else{
            return response()->json(['error'=>'Failed to update data'], 404);
        }

    }

    public function deleteUser(Request $request){
        $user = User::find($request->id);
        if($user->delete()){
            return response()->json(['success'=>true], 200);
        }else{
            return response()->json(['success'=>false], 500);
        }
    }
}
