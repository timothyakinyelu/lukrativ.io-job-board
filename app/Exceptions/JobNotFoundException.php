<?php

namespace App\Exceptions;

use Exception;

class JobNotFoundException extends Exception
{
    public function report()
    {
        \Log::debug('Job post not found');
    }
}
