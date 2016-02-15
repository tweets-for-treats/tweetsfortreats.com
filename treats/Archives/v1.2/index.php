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

?>


<!DOCTYPE html>

<html>
<head>
	<title>Tweets for Treats</title>
	
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
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
	
	<link href='treats.css' rel='stylesheet' type='text/css'>

	
	<style type="text/css">
		
	</style>

	<script type="text/javascript">
		var readyStateCheckInterval = setInterval(function() {
		if (document.readyState === "complete") {
			if(window.navigator.standalone){
				document.getElementById("container").style.padding="25% 0 0";
				document.getElementById("container").style.height="75%";
			}
			clearInterval(readyStateCheckInterval);
			}
		}, 10);
	</script>
</head>

<body>
	<?php errorPrint(); ?>
	<div id="container">
		<div id="logo">
			<span class="blk">BLK</span><span class="sun">SUN</span>
		</div>
		<h1>TREATS FOR TREATS</h1>
		<?php if(isset($_SESSION['loged']) && $_SESSION['loged']) : ?>
		<?php $savedSettings = get_settings(); //printl($savedSettings)?>
		<?php $users = get_users();?>
		<form id="form" action="index.php" method="post">
			<!-- Hastag -->
			<input type="text" name="hashtag" onfocus="this.value = '';" value="<?php echo ($savedSettings[0]['hashtag']) ? $savedSettings[0]['hashtag'] : 'enter hashtag' ?>">
			<!-- Duration -->
			<label><select name="duration">
				<?php
				for($i=1; $i<=10; $i++){
					echo '<option class="item" '.($savedSettings[0]['duration'] == $i ? 'selected' : '').' value="'.$i.'">'.$i.($i==1 ? ' second' : ' seconds').'</option>';
				}
				for($i=60; $i<=600; $i+=60){
					echo '<option class="item" '.($savedSettings[0]['duration'] == $i ? 'selected' : '').' value="'.$i.'">'.($i/60).($i==60 ? ' minute' : ' minutes').'</option>';
				}
				?>
			</select>
			</label>
			<!-- Handle -->
			<label><select name="user_id">
				<?php
				foreach($users as $user){
					echo '<option class="item" '.($user['user_id'] == $savedSettings[0]['user_id'] ? 'selected' : '').' value="'.$user['user_id'].'">'.$user['screen_name'].'</option>';
				}
				
				?>
			</select>
			</label>
			<!-- Set Time Reset -->
			<input type="time" name="time_reset" value="<?php echo date("H:i",$savedSettings[0]['time_reset']) ?>">
			
			
			<!-- Submit -->
			<input type="submit" value="Save Settings" >
		</form>
		<?php else: ?>
		<form id="form" action="login_check.php" method="post">
			<input type="password" name="password">
			<input type="submit" value="LET ME IN!" >
		</form>
		<?php endif; ?>
	</div>


</body>
</html>

<?php //var_dump($_SESSION); ?>