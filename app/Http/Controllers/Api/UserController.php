<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\NewUserRequest;
// use App\Mail\NewUserResetPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
// use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserResetPasswordMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use Image;
use Storage;
use Auth;

class UserController extends Controller
{
    /*
    |-------------------------------------------------------------------------------
    | Get All Users
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/users
    | Method:         GET
    | Description:    Gets all of the users in the application
    */
    public function index() 
    {
        return UserCollection::collection(User::paginate(10));
    }

    /*
    |-------------------------------------------------------------------------------
    | Adds a New User
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/users
    | Method:         POST
    | Description:    Adds a new user to the application
    */

    public function create(NewUserRequest $request) 
    {
        // dd($request->all());
        if(Auth::user()->can('create', [ User::class])) {
            //generate a password for the new users
            if($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                
                $filename = time() . '.' . $avatar->getClientOriginalName();
                Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatar/' .$filename ) );
            }
            
            $pw = User::generatePassword();

            //add new user to database
            $user = new User;
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->password = $pw;
            $user->permission = $request->input('permission');
            $user->avatar = $avatar->storeAs('public', $filename);

            $user->save();
        
            $email = $user->email;
            $this->sendUserEmail($user, $email);
            if ($user) {
                return $this->successResponseUser();
            } else {
                return $this->failedResponse();
            }
        }
        return response()->json('Unable to create user', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    | Fetch An Individual User to edit
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/users/{id}/edit
    | Method:         GET
    | Description:    Gets an individual user to edit,access for only super admins
    */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'user' => $user
        ]);
    }

    /*
    |-------------------------------------------------------------------------------
    | Fetch A Users details for update by that user
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/users/{id}/editSelf
    | Method:         GET
    | Description:    Gets a users details for update
    */
    public function editSelf()
    {
        $id = Auth::user()->id;

        $user = User::findOrFail($id);

        return response()->json([
            'user' => $user
        ]);
    }

    /*
    |-------------------------------------------------------------------------------
    | Show An Individual User
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/users/{id}/show
    | Method:         GET
    | Description:    Shows an individual user for only super admins
    */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /*
    |-------------------------------------------------------------------------------
    | Update An Individual User
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/users/{user}/edit
    | Method:         PUT
    | Description:    Updtes an individual user
    */
    public function update(User $user, Request $request) 
    {
        if(Auth::user()->can('update', $user) ) {

            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $email = $request->get('email');

            /*
                Ensure the user has entered a first name
            */
            if( $first_name != '' ){
                $user->first_name    = $first_name;
            }

            /*
                Ensure the user has entered a last name
            */
            if( $last_name != '' ){
                $user->last_name       = $last_name;
            }

            /*
                Ensure the user has submitted an email
            */
            if( $email != '' ){
                $user->email = $email;
            }

            if($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatar/' .$filename ) );
    
                $oldPhoto = $user->avatar;

                $user->avatar = $avatar->storeAs('public', $filename);
                $user->save();

                $oldPhoto->delete();
                unlink(public_path('/uploads/avatar/' .$filename ));
            }
            
            $user->save();  
       
            return response()->json( new UserResource($user), 201 );
        }
        return response()->json('Unable to update user', 204);
    }

    public function sendUserEmail($user, $email) 
    {
        //New user password reset code
        $token = $this->createToken($email);
        $user->notify(new NewUserResetPasswordMail($token));
    }

    public function failedResponse() 
    {

        return response()->json([
            'error' => 'Token not generated.'
        ], Response::HTTP_NOT_FOUND);
    }

    public function successResponseUser() 
    {
        return response()->json([
            'data' => 'Password Reset Email has been sent to Users Inbox.'
        ], Response::HTTP_OK);
    }

    public function createToken($email) 
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first();
        if ($oldToken) {
            return $oldToken->token;
        }

        $token = Str::random(60);
        $this->saveToken($token, $email);
        return $token;
    }

    public function saveToken($token, $email) 
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function destroy($id) 
    {
        $user = User::find($id);
        
        $user->delete();
        Storage::delete($user->avatar);

        return response()->json([
            'data' => 'User deleted'
        ]);
    }
}
