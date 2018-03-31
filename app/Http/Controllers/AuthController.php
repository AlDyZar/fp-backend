<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /*
    Register User
    */
    public function register(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:users',
                'name' => 'required',
                'last_name' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    $validator->errors(),
                    422);
            }

            User::create([
                'name' => $request->input('name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]);
        }catch (\Exception $e){
            return response()->json([
                'msg' => ['Server error', $e->getMessage()],
            ], 500);
        }

        return response([
            'data' => User::first(),
        ], 200);
    }

    /*
     Login User
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'msg' => ['Incorrect email/password'],
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'msg' => ['Server error'],
            ], 500);
        }

        return response([
            'status' => true,
            'data' => [
                'token' => $token,
                'user' => auth()->user()
            ]
        ], 200);
    }

    /*
     * Logout
     */
    public function logout(){
        try {
            JWTAuth::invalidate();

            return response([
                'status' => true,
            ], 200);
        }catch (JWTException $e){

            return response([
                'status' => false,
            ], 500);
        }
    }

    public function me(){
        try {
            $user = auth()->user();
            return response([
                'data' => [
                    'user' => $user
                ]
            ], 200);
        }catch (JWTException $e){
            return response([
                'status' => false,
            ], 500);
        }
    }
}
