<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
    */
    public function render($request, $exception)
    {
        return response()->json([
            'error' => 'User not found!'
        ], Response::HTTP_NOT_FOUND);
    }
}
