<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserProfle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->routes('profile'); // For example, the current URL is: /profile/1/edit

        $user = User::findOrFail($id); // Fetch the user

        if($user->id == Auth::user()->id || Auth::user()->permission == config('constants.SUPER-ADMIN'))
        {
            return $next($request); // They're the owner, lets continue...
        }

        return redirect()->to('/'); // Nope! Get outta' here.
    }
}
