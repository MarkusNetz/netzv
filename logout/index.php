<?php
$top_level="../";
require_once( $top_level . "ini/" . "settings.php" );

// execute logout function.
logout();

function logout(){
	echo "<p>Påbörjar utloggning.</p>";
	// Unset all session values
	$_SESSION = array();

	// get session parameters 
	$params = session_get_cookie_params();

	// Delete the actual cookie. 
	setcookie(session_name(),
		'', time() - 42000, 
		$params["path"], 
		$params["domain"], 
		$params["secure"], 
		$params["httponly"]);

	// Destroy session
	session_destroy();

	header("Location: ../index.php");
}