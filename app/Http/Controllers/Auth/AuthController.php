<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'email'=> 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);
        if($validator->fails())
        {
            return $this->fail($validator->errors(), 403);
        }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =Hash::make($request->password);
            $user->save();
            $token = $user->createToken('sarbelgyi')->plainTextToken;
            return $this->response('registered', ['user'=>$user,'token' => $token],[]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return $this->fail($validator->errors(), 403);
        }
        $user = User::where('email', $request->email)->first();
        if($user)
        {
            if(Hash::check($request->password,$user->password)) {
                $token = $user->createToken('first-ict')->plainTextToken;
                return $this->response('logged in', ['user'=>$user,'token' => $token],[]);
            }else {
                return $this->fail(['message'=> "password credential"],404);
            }
        }
        else {
            return $this->fail(['message'=> "there is no user with this email"],403);
        }
    }
    public function logout(Request $request)
    {
        //delete the token in db
        $user = $request->user();
        $request->user()->currentAccessToken()->delete();
        return $this->response('',$user,[]);
    }

}
