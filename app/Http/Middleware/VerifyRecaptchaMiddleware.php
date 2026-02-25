<?php

namespace App\Http\Middleware;

use Closure;
use \App\Traits\VerifyRecaptchaTrait;

class VerifyRecaptchaMiddleware
{
    use VerifyRecaptchaTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->verifyRecaptchaOrFail();

        return $next($request);
    }
}
