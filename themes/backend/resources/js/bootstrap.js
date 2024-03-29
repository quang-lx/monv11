
window._ = require('lodash');
import axios from 'axios';

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// try {
//     window.$ = window.jQuery = require('jquery');
//
//     require('bootstrap-sass');
// } catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios.create();

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    console.log(error.response)
    if (error.response.status === 401) {
       window.location.href = '/logout'; //relative to domain
    }
    return Promise.reject(error)
})
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');
console.log(token.content);
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

let userApiToken = document.head.querySelector('meta[name="user-api-token"]');

if (userApiToken) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + userApiToken.content;
} else {
    console.error('User API token not found in a meta tag.');
}


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
