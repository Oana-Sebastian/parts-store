<?php

namespace App\Exceptions;

use Exception;

class PartNotFoundException extends Exception
{
    protected $message = 'The requested part could not be found';
    protected $code = 404;

    public function render($request)
    {
        return response()->view('errors.part-not-found', [
            'message' => $this->getMessage()
        ], 404);
    }
}