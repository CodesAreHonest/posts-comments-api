<?php


namespace App\Exceptions;

use Exception;

class BadGatewayException extends Exception
{
    private $error;
    private $debug;
    private $statusCode = 502;

    public function __construct($error = null, $debug = null)  {
        $this->error = $error;
        $this->debug = $debug;
    }

    public function render() {

        $returnParams = [
            'status'    => $this->statusCode,
            'message'   => 'Bad Gateway'
        ];

        if ($this->error) {
            $returnParams['error'] = $this->error;
        }

        if ($this->debug) {
            $returnParams['debug'] = $this->debug;
        }

        return response()->json($returnParams, $this->statusCode);
    }
}
