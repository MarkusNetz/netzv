<?php

/*
** Determines wheather or not a user is logged in.
*/
$loggedInUser=null;
if( $LoginCheck->LoginCheck($dbConn) == true ) {
	$loggedInUser = new loggedInUser($dbConn);
}
else {}