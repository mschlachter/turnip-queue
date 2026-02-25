<?php

namespace App\Traits;

use \Illuminate\Validation\ValidationException;
use Http;

trait VerifyRecaptchaTrait
{
    protected function verifyRecaptchaOrFail()
    {
        if (!$this->verifyRecaptcha()) {
            $error = ValidationException::withMessages([
               'recaptcha' => 'ReCaptcha verification failed, please try again.',
            ]);
            throw $error;
        }
    }

    protected function verifyRecaptcha()
    {
        $responseToken = request('g-recaptcha-response');
        if (!$responseToken) {
            return false;
        }
        
        $secret = config('recaptcha.secret-key');
        $apiUrl = 'https://www.google.com/recaptcha/api/siteverify';

        $response = Http::asForm()->post($apiUrl, [
            'secret' => $secret,
            'response' => $responseToken,
        ]);

        if ($response->successful()) {
            return $response['success'];
        }

        return false;
    }
}
