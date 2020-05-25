<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
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

    // public function create( User $user )
    // {
    //     $userRole = $user->role;

    //     if( $userRole->permission == 2 || $userRole->permission == 3 || $userRole->permission == 4 ){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }


    /**
     * If a user is super admin.
     *
     * @param \App\User  $user
     * 
    */

    public function update( User $user )
    {
        $userRole = $user->permission;
        
        if( $userRole == config('constants.EMPLOYER') || $userRole == config('constants.ADMIN') || $userRole == config('constants.SUPER-ADMIN') ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * If a user is an admin or super admin.
     *
     * @param \App\User  $user
     * 
    */

    public function delete( User $user )
    {
        $userRole = $user->permission;
        
        if( $userRole == config('constants.ADMIN') || $userRole == config('constants.SUPER-ADMIN') ){
            return true;
        }else{
            return false;
        }
    }
}
