<?php

/**This code doesn't change the lifetime of the session when the user gets 
 * back at our site or refreshes the page. The session WILL expire after $lifetime seconds,
 *  no matter how many times the user requests the page. */
if (session_status() == PHP_SESSION_NONE) {
    // $lifetime = 600;
    // session_set_cookie_params($lifetime);
    session_start();
}


/** Same session cookie with the lifetime set to the proper value. */
// if (session_status() == PHP_SESSION_NONE) {
//     $lifetime = 600;
//     // session_set_cookie_params($lifetime);
//     session_start();
//     setcookie(session_name(),session_id(),time()+$lifetime);
// }

