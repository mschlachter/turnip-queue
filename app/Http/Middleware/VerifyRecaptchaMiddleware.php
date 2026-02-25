<?php

namespace App\Http\Middleware;

use App\Traits\VerifyRecaptchaTrait;
use Closure;

class VerifyRecaptchaMiddleware
{
    use VerifyRecaptchaTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->verifyRecaptchaOrFail();

        return $next($request);
    }
}
