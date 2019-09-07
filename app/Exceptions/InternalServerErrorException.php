<?php


namespace App\Exceptions;

use Exception;

class InternalServerErrorException extends Exception
{
    private $error;
    private $debug;
    private $errorCode;
    private $statusCode = 500;

    public function __construct($error = null, $errorCode = null, $debug = null)  {
        $this->error = $error;
        $this->debug = $debug;
        $this->errorCode = $errorCode;
    }

    public function render() {

        $returnParams = [
            'status'    => $this->statusCode,
            'message'   => 'Internal Server Error',
            'error'     => $this->error
        ];

        if ($this->error) {
            $returnParams['error'] = $this->error;
        }

        if ($this->errorCode) {
            $returnParams['code'] = $this->errorCode;
        }

        if ($this->debug) {
            $returnParams['debug'] = $this->debug;
        }

        return response()->json($returnParams, $this->statusCode);
    }
}
