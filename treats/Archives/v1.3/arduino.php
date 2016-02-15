<?php

	/* usefull info
	 * https://dev.twitter.com/docs/auth/authorizing-request
	 *
	 *
	 *
	 *
	 *
	 **/
	
	define('ARDUINO', TRUE);
	//Start the Session if it hasn't been started already
	if(!isset($_SESSION)) session_start();
	
	//session_destroy();
	require_once('utilities.php');
?>
