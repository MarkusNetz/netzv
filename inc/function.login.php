<?php
// -----
// Säker sessionsstart
// -----
function sec_session_start()
{
    $session_name = 'netzarna_session_id';   // Set a custom session name
    $secure = SECURE; // Denna hämtas från db-config (utanför webroot) som har en konstant som heter SECURE. Där sätts värdet.
    
	// This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
	// each client should remember their session id for EXACTLY 1 hour
	$lifetimesec=3600*24*3;
	ini_set('session.gc_maxlifetime', $lifetimesec);
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($lifetimesec,
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
	
	// Sets the session name to the one set above.
	session_name($session_name);
	session_start();            // Start the PHP session 
	session_regenerate_id(true);    // regenerated the session, delete the old one. 
}
// SLUT - säker sessionsstart.


// ----
// Funktion för kontroll att man är inloggad
// ----
// SLUT.

// Escape URL.
function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $PhpSelf
        return '';
    } else {
        return $url;
    }
}
