<?php

namespace App\Exceptions;

use App\Exceptions\UnprocessableEntityException;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        // 422
        if ($exception instanceof UnprocessableEntityException)  {
            return $exception->render();
        }

        // 500
        if ($exception instanceof InternalServerErrorException)  {
            return $exception->render();
        }

        // 502
        if ($exception instanceof BadGatewayException)  {
            return $exception->render();
        }

        // 403
        if ($exception instanceof ForbiddenException)  {
            return $exception->render();
        }

        // 401
        if ($exception instanceof UnauthenticatedException)  {
            return $exception->render();
        }

        return parent::render($request, $exception);
    }
}
