<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\tokens;
use App\Http\Controllers\HasApiTokens;
use Illuminate\Http\Auth;

class AuthController extends Controller
{
   public function index(){
     return  User::all();



   }
   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }


    public function register(Request $request)
{
            $fields=$request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed',

            ]);
            $user=User::create([
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password']),
            ]);


            $token=$user->createToken('myapptoken')->plainTextToken;
            $response=[
                'user'=>$user,
                'token'=>$token,

            ];

            return response($response,201);

    }
    public function login(Request $request)
    {
    $fields=$request->validate([

    'email'=>'required|string',
    'password'=>'required|string',

    ]);
    //check email
    $user=User::where('email', $fields['email'])->first();
    //check password
    if (!$user || !Hash::check($fields['password'], $user->password)) {
        return response([
            'message'=>'Bad Creds'


        ], 401);
    }

    $token=$user->createToken('myapptoken')->plainTextToken;
    $response=[
        'user'=>$user,
        'token'=>$token,

    ];

    return response($response, 201);
}
    public function logout(Request  $request)
    {
       $request->user()->tokens()->delete();

        return [
            'message'=>'logged out , Done!'
        ];
    }
}
