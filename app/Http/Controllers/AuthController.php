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
                'password' => 'required|confirmed',
                'address' => 'required',
                'city' => 'required',
                'postal_code' => 'required',
                'phone' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    $validator->errors(),
                    422);
            }

            //return response($request->input('postal_code'), 500);

            User::create([
                'name' => $request->input('name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postal_code' =>$request->input('postal_code'),
                'phone' => $request->input('phone')
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
     *  Update User
     */
    public function updateProfile(Request $request){
        try {


            $user = auth()->user();

            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'name' => 'required',
                'last_name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'postal_code' => 'required',
                'phone' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    $validator->errors(),
                    422);
            }

            $updatedUser = User::where('id', $user['id'])->update([
                'name' => $request->input('name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
//                'password' => bcrypt($request->input('password')),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postal_code' =>$request->input('postal_code'),
                'phone' => $request->input('phone')
            ]);

        }catch (\Exception $e){
            return response()->json([
                'msg' => ['Server error', $e->getMessage()],
            ], 500);
        }

        return response([
            'data' => User::find($user['id']),
        ], 200);
    }

    /*
     *  Login User
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
            'token' => $token,
            'user' => auth()->user()
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

    /*
     *  Return Authenticated User
     */
    public function me(){
        try {
            $user = auth()->user();
            return response([
                'user' => $user
            ], 200);
        }catch (JWTException $e){
            return response([
                'msg' => ['Server error'],
            ], 500);
        }
    }
}
