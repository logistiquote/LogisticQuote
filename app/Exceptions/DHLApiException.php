<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DHLApiException extends Exception
{
    public function __construct(string $message, int $code = 500)
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request)
    {
        Log::error("DHL API Error: {$this->message}", ['status' => $this->code]);

        return response()->view('errors.dhl', [
            'error' => 'DHL API Error',
            'message' => $this->message,
        ], $this->code);
    }
}


