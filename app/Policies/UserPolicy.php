<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    
    /**
     * If a user is a super admin.
     *
     * @param \App\User  $user
     * 
    */
    public function create( User $user ){
        $userRole = $user->permission;

        if( $userRole == config('constants.SUPER-ADMIN') ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * All users can read their profile.
     *
     * @param \App\User  $user
     * 
    */
    public function read( User $user ){
        $userRole = $user->permission;

        if( $userRole >= config('constants.USER') ){
            return true;
        }else{
            return false;
        }
    }


    /**
     * All users can update their profile.
     *
     * @param \App\User  $user
     * 
    */
    public function update( User $user ){
        $userRole = $user->permission;
        
        if( $userRole >= config('constants.USER') ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * If a user is a super admin.
     *
     * @param \App\User  $user
     * 
    */
    public function delete( User $user ){
        $userRole = $user->permission;
        
        if( $userRole == config('constants.SUPER-ADMIN') ){
            return true;
        }else{
            return false;
        }
    }
}
