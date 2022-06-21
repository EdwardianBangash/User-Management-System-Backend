<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index(){
        $user = User::all();
        return response()->json(array('data' => $user));
    }

    public function addUser(Request $request){
        $request->validate([
            'fullname'=>'required|string',
            'email'=>'required|string|email',
            'address'=>'required|string'
        ]);
    }

    public function updateUser(Request $request, $id){
        $request->validate([
            'fullname'=>'required|string',
            'email'=>'required|string|email',
            'address'=>'required|string'
        ]);
    }
}
