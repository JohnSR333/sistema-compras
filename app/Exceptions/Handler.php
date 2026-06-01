<?php

namespace App\Exceptions;

use App\Exceptions\NotFoundException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\TokenMismatchException;
use App\Exceptions\InternalServerErrorException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundException) {
            return $exception->render($request);
        }
        
        if ($exception instanceof ForbiddenException) {
            return $exception->render($request);
        }
        
        if ($exception instanceof TokenMismatchException) {
            return $exception->render($request);
        }
        
        if ($exception instanceof InternalServerErrorException) {
            return $exception->render($request);
        }

        return parent::render($request, $exception);
    }
}