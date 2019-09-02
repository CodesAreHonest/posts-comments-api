<?php


namespace App\Exceptions;

use Exception;

class UnprocessableEntityException extends Exception
{

    private $error;
    private $debug;
    private $statusCode = 422;

    public function __construct($error, $debug = null)  {
        $this->error = $error;
        $this->debug = $debug;
    }

    public function render() {

        $returnParams = [
            'status'    => $this->statusCode,
            'message'   => 'Unprocessable Entity',
            'error'     => $this->error
        ];

        if ($this->debug) {
            $returnParams['debug'] = $this->debug;
        }

        return response()->json($returnParams, $this->statusCode);
    }
}
