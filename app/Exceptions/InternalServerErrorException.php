<?php


namespace App\Exceptions;

use Exception;

class InternalServerErrorException extends Exception
{
    private $error;
    private $debug;
    private $statusCode = 500;

    public function __construct($error, $debug = null)  {
        $this->error = $error;
        $this->debug = $debug;
    }

    public function render() {

        $returnParams = [
            'status'    => $this->statusCode,
            'message'   => 'Internal Server Error',
            'error'     => $this->error
        ];

        if ($this->debug) {
            $returnParams['debug'] = $this->debug;
        }

        return response()->json($returnParams, $this->statusCode);
    }
}
