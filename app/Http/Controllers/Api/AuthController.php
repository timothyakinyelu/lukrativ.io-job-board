<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Exceptions\UserNotFoundException;
use App\Services\UserService;
use Auth;
use Hash;
use Validator;
use App\User;

class AuthController extends Controller
{
    /*
    |   This handles all access into the admin 
    |   section of the website.
    */
    public function register(Request $request) 
    {
        // var_dump($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        if ($validator->fails())
        {
            return response()->json(
                ['errors'=>$validator->errors()->all()]
            , 422);
        }

        $request['password'] = Hash::make($request['password']);

        $user = new User();
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->permission = $request['permission'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        // $user = User::create($request->all());
        $user->save();

        $token = $user->createToken('florashaw')->accessToken;
        $success = ['token' => $token];
    
        return response()->json($success, 200);
    }

    // public function login(Request $request) 
    // {
    //     $user = User::where('email', $request->email)->first();

    //     if ($user) {
    //         if (Hash::check($request->password, $user->password)) {
    //             $token = $user->createToken('florashaw')->accessToken;
    //             $success['token'] = $token;
    //             $success['user'] = $user;
    //             return response()->json($success, 200);
    //         } else {
    //             $success['error'] = "Wrong password. Try again or click Forgot password to reset it";
    //             return response()->json($success, 500);
    //         }

    //     } else {
    //         $success['error'] = 'Email provided does not exist';
    //         return response()->json($success, 500);
    //     }
    // }

    public function checkEmail(Request $request) 
    {
        $user = User::where('email', $request->email)->first();

        if($user) {
            $email = $user->email;
            $success['status'] = true;
            $success['email'] = $email;
            return response()->json($success, 200);
        } else {
            $success['error'] = 'Email provided does not exist';
            return response()->json($success, 500);
        }
    }

    public function confirmPassword(Request $request) 
    {
        $user = User::where('email', $request->email)->first();

        if($this->checkEmail($request) == true) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('florashaw')->accessToken;
                // $cookie = $this->getCookieDetails($token);
                $success['token'] = $token;
                $success['user'] = $user;
                return response()
                    ->json($success, 200);
                    // ->cookie(
                    //     $cookie['name'],
                    //     $cookie['value'],
                    //     $cookie['minutes'],
                    //     $cookie['path'],
                    //     $cookie['domain'],
                    //     $cookie['secure'],
                    //     $cookie['httponly'],
                    //     $cookie['samesite']
                    // );
            } else {
                $success['error'] = "Invalid user credentials.";
                return response()->json($success, 500);
            }
        }
    }

    // private function getCookieDetails($token) 
    // {
    //     return [
    //         'name' => '_token',
    //         'value' => $token,
    //         'minutes' => 900,
    //         'path' => null,
    //         'domain' => null,
    //         // 'secure' => true, for production
    //         'secure' => null,
    //         'httponly' => true,
    //         'samesite' => true

    //     ];
    // }

    //Gets authenticated user after login
    public function getUser(UserService $userservice) 
    {
        $id = Auth::user()->id;

        try {
            $user = $userservice->user($id);

            return response()->json([
                'data' => new UserResource($user)
            ], 200);
        } catch(UserNotFoundException $e) {
            render($e);

            return false;
        }
    }
}
