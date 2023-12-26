<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use stdClass;

class AuthController extends Controller
{
    public function register(Request $request){
        if($request->adminCode == $_ENV["ADMIN_CODE"]){
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required'
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors());
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()
                ->json(['data'=>$user,'access_token'=>$token,'token_type'=>'Bearer']);
        }
        else{
            return [
                'message' => 'Codigo de administrador incorrecto.'
            ];
        }
        
    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email','password')))
        {
            return response()->json(['message'=>'Unauthorized'],401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Authorized',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}