// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

import BSN from './bootstrap-native/index.js';

try {
    // window.Popper = require('popper.js').default;
    // window.$ = window.jQuery = require('jquery');

	// Use native js bootstrap (smaller filesize)
	window.BSN = BSN;

    // require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Custom function to get values from meta tags
 */

window.meta = function(key) {
	let metaTag = document.querySelector('meta[name=' + key + ']');
	return metaTag.content;
};

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";
window.echo_loaded = false;

window.requireEcho = function() {
    if (window.echo_loaded) return;
    window.echo_loaded = true;

    window.Pusher = require('pusher-js');

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: meta('pusher-token'),
        cluster: 'us2',
    });
};
