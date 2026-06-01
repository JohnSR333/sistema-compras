<?php

namespace App\Exceptions;

use Exception;

class InternalServerErrorException extends Exception
{
    public function render($request)
    {
        return response()->view('errors.500', [], 500);
    }
}
