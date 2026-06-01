<?php

namespace App\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    public function render($request)
    {
        return response()->view('errors.403', [], 403);
    }
}
