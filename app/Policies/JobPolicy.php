<?php

namespace App\Policies;

use App\User;
use App\Job;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
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

    // public function create( User $user ){
    //     $userRole = $user->permission;

    //     if( $userRole == '' || $userRole == 2 || $userRole == 3 ){
    //         return true;
    //     }else if( $company != null && $user->companies->contains( $company->id ) ){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    /**
     * If a user is an admin or super admin OR they own the
     * company then can edit the job.
     *
     * @param \App\User  $user
     * @param \App\Job  $job
    */

    public function update( User $user, Job $job ){
        $userRole = $user->permission;

        if( $userRole == config('constants.ADMIN') || $userRole == config('constants.SUPER-ADMIN') ){
            return true;
        } else {
            return false;
        }
    }

    /**
     * If a user is an admin or super admin OR they own the company
     * then they can delete the job.
     *
     * @param \App\User  $user
     * @param \App\Job $job
    */

    public function delete( User $user, Job $job ){
        $userRole = $user->permission;

        if( $userRole == config('constants.ADMIN') || $userRole == config('constants.SUPER-ADMIN') ){
            return true;
        } else {
            return false;
        }
    }
}
