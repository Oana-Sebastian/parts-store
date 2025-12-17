<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    protected $message = 'Insufficient stock available for this part';
    protected $code = 400;

    public function __construct(string $message = '', int $availableStock = 0)
    {
        $this->message = $message ?: "Only {$availableStock} items available in stock";
        parent::__construct($this->message, $this->code);
    }

    public function render($request)
    {
        return response()->view('errors.insufficient-stock', [
            'message' => $this->getMessage()
        ], 400);
    }
}