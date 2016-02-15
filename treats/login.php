<?php

/* usefull info
 * https://dev.twitter.com/docs/auth/authorizing-request
 *
 *
 *
 *
 *
 **/

//Start the Session if it hasn't been started already
if(!isset($_SESSION)) session_start();

//session_destroy();

require_once('utilities.php');

if(checkMemberLogin()) {
    go_to_home_page();
}

?>


<!DOCTYPE html>

<html>
<head>
	<title>Tweets for Treats - Settings</title>
	
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="apple-touch-icon" href="touch-icon-iphone.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/touch-icon-ipad.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/touch-icon-iphone-retina.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/touch-icon-ipad-retina.png">
	<!-- For android -->
	<link rel="apple-touch-icon-precomposed" href="images/touch-icon-iphone-retina.png"/>
	<!-- Splash Screen -->
	<link rel="apple-touch-startup-image" href="images/startup.png">
    <link rel="icon" type="image/png" href="../img/favicon.png">
	<link href='treats-admin.css' rel='stylesheet' type='text/css'>

	
	<style type="text/css">
		
	</style>

</head>

<body>
        <section class="form-container">
            <div class="form-center">
                <div id="logo">
                    <img src="../img/tweets-for-treats-logo-white.svg">
                </div>
                <form id="form" action="login_check.php" method="post">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" value="Login" class="btn-outline-inverted">
                </form>
            </div>
        </section>

        <div class="error-container">
                <?php errorPrint(); ?>
        </div>


        <script src="../js/jquery.1.11.1.min.js"></script>
        <script src="treats-admin.js"></script>


</body>
</html>

<?php //var_dump($_SESSION); ?>