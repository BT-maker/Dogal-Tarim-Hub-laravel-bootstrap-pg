<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['login','register']]);
    }


    //Kullanıcı kayıt
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:64|max:64', //SHA-256 hash 64 karakter
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, //Model'de bcrypt ile hash
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'User succesfully registered',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    //Kullanıcı giriş
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:64|max:64', //SHA-256
        ]);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        //Kullanıcıyı email ile bul
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        //frontend'den gelen SHA-256 hash ile veritabanındaki bcrypt hash'i karşilaştır
        if (!Hash::check($request->password, $user->password)){
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    //Kullanıcı çıkış
    public function logout()
    {
        try{
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout'
            ], 500);
        }
    }


    //Token yenileme
    public function refresh()
    {
        try{
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'token' => $token
            ]);
        } catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Token refresh failed'
            ], 401);
        }
    }


    //Kullanıcı profili
    public function profile()
    {
        return response()->json([
            'success' => true,
            'user' => JWTAuth::user()
        ]);
    }

}
