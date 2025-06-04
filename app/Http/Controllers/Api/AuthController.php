<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\sendOTP;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);


        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        return response()->json([
            'status'=>'200',
            'Message'=>"User register successfully",
            'token'=>$user->createToken('api-token')->plainTextToken,
        ]);
    }



    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password , $user->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
          'token'=>$user->createToken('api-token')->plainTextToken,
        ]);

    }



    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'status'=>'200',
            'Message'=>"User logout successfully",
        ]);
    }


    public function sendOTP(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $otp = rand(100000, 999999);

        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new sendOTP($otp));

        return response()->json(['message' => 'OTP sent to your email']);

    }


    public function verifyOTpAndChangPassworrd(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'otp_code' => 'required',
            'email' => 'required',
        ]);

        $user = User::where('otp_code',$request->otp_code)
            ->where('email',$request->email)
            ->where('otp_expires_at','>=',Carbon::now())->first();


        if (!$user) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }



        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json([
            'status'=>'200',
            'Message'=>"Password changed successfully",

        ]);


    }



    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status'=>'200',
            'Message'=>"Refresh token successfully",
            'token'=>$token,
        ]);

    }


}
