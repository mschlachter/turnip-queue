<?php

return [
    'google-analytics-key' => env('GA_KEY'),
    'tag-manager-key' => env('GTM_KEY'),
    'use-plausible' => env('USE_PLAUSIBLE', false),
    'plausible-domain' => env('PLAUSIBLE_DOMAIN', preg_replace('/^https?:\/\/(www\.)?/i', '', env('APP_URL'))),
    'plausible-script' => env('PLAUSIBLE_SCRIPT', 'https://plausible.io/js/plausible.js'),
];
