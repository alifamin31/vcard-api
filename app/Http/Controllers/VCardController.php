<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VCardController extends Controller
{
    public function register(Request $request)
    {
        $user = DB::table('user_details')->where('email', $request['email']);
        if($user->exists()) {
            return response()->json('Email Already Exist');
        } else {
            if($request['email'] == '') {
                return response()->json('Email Is Empty', 200);
            } else if($request['username'] == '') {
                return response()->json('Username Is Empty', 200);
            } else if($request['password'] == '') {
                return response()->json('Password Is Empty', 200);
            } else if($request['fullname'] == '') {
                return response()->json(' Fullname Is Empty', 200);
            } else if($request['employment'] == '') {
                return response()->json('Employment Is Empty', 200);
            } else if($request['phone_number'] == '') {
                return response()->json('Phone Number Is Empty', 200);
            } else {
                DB::table('user_details')->insert([
                    'email' => $request['email'],
                    'username' => $request['username'],
                    'password' => password_hash($request['password'], PASSWORD_DEFAULT),
                    'fullname' => $request['fullname'],
                    'employment' => $request['employment'],
                    'phone_number' => $request['phone_number'],
                ]);

                $res = [
                    "id"=>$user->first()->id,
                ];

                return response()->json($res, 200);
            }
        }
    }

    public function login(Request $request)
    {
        if(isset($request['email'])) {
            $user=DB::table('user_details')->where('email', $request['email']);
            if ($user->exists()){
                $pass=$user->first()->password;
                if(password_verify($request['password'], $pass)){
                    $res=[
                        'id'=>$user->first()->id,
                        'email'=>$user->first()->email,
                        'username'=>$user->first()->username,
                        'fullname'=>$user->first()->fullname,
                        'employment'=>$user->first()->employment,
                        'phone_number'=>$user->first()->phone_number,
                    ];
                    return response()->json($res, 200);
                } else {
                    print_r(password_verify($request['password'], $pass));
                    // return response()->json('Wrong Password. Please Try Again');
                }
            } else {
                return response()->json('Username Do Not Exist');
            }
        }
    }
}
