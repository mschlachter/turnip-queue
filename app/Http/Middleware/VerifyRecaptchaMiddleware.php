<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Validation\ValidationException;
use Http;

class VerifyRecaptchaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->verifyRecaptcha()) {
            $error = ValidationException::withMessages([
               'recaptcha' => 'ReCaptcha verification failed, please try again.',
            ]);
            throw $error;
        }

        return $next($request);
    }

    private function verifyRecaptcha()
    {
        $responseToken = request('g-recaptcha-response');
        if(!$responseToken) {
            return false;
        }
        
        $secret = config('recaptcha.secret-key');
        $apiUrl = 'https://www.google.com/recaptcha/api/siteverify';

        $response = Http::asForm()->post($apiUrl, [
            'secret' => $secret,
            'response' => $responseToken,
        ]);

        if($response->successful()) {
            $success = $response['success'];

            return $success;
        }
        return false;
    }
}
