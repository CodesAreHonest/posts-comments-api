<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthenticatedException;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class PassportAuthentication
{
    /**
     * Handle an incoming request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws UnauthenticatedException
     */
    public function handle($request, Closure $next)
    {

        $header = $request->header('Authorization');

        if (!$request->headers->has('Authorization')) {
            throw new UnauthenticatedException();
        }

        $key = file_get_contents(storage_path('oauth-public.key'));

        try {
            $decodedData = JWT::decode(substr($header, 7), $key, array('RS256'));
            $request->merge(['user_sub' => $decodedData->sub]);
            return $next($request);

        }
        catch (ExpiredException $e) {
            throw new UnauthenticatedException($e->getMessage());
        }

    }
}
