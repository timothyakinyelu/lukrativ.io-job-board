<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Exceptions\UserNotFoundException;
use App\User;

class UserService {
    public function user($id) 
    {
        $user = User::find($id);

        if(!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}