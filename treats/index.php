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
redirectCheckMemberLogin();


$savedSettings = get_settings();
$users = get_users();
		
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
                
                <form id="form" action="index.php" method="post">
                    <!-- Hastag -->
                    <input type="text" class="hashtag" name="hashtag" placeholder="hashtag" onfocus="this.value = '';" value="<?php echo ($savedSettings[0]['hashtag']) ? $savedSettings[0]['hashtag'] : 'enter hashtag' ?>">
                    <!-- Duration -->
                    <span class="select" style="display:none">
                        <span class="prefix time"></span>
                        <span class="value">1 second</span>
                        <select name="duration">
                            <?php
                            for($i=1; $i<=10; $i++){
                                echo '<option class="item" '.($savedSettings[0]['duration'] == $i ? 'selected' : '').' value="'.$i.'">'.$i.($i==1 ? ' second' : ' seconds').'</option>';
                            }
                            for($i=60; $i<=600; $i+=60){
                                echo '<option class="item" '.($savedSettings[0]['duration'] == $i ? 'selected' : '').' value="'.$i.'">'.($i/60).($i==60 ? ' minute' : ' minutes').'</option>';
                            }
                        ?>
                        </select>
                    </span>
                    <!-- Set Time Reset -->
                    <!-- <input style="display:none" type="time" class="reset" name="time_reset" value="<?php echo date("H:i",$savedSettings[0]['time_reset']) ?>"> -->
                    <!-- Handle -->
                    <span class="select">
                        <span class="prefix handle"></span>
                        <span class="value">
				<?php
				$screen_name = 'No Twitter Handle';
				foreach($users as $user){
					if($user['user_id'] == $savedSettings[0]['user_id']) {
						$screen_name = $user['screen_name'];
						break;
					}
				}
				echo $screen_name;
				?>
			</span>
			<select name="user_id">
                            <?php
                            foreach($users as $user){
                                echo '<option class="item" '.($user['user_id'] == $savedSettings[0]['user_id'] ? 'selected' : '').' value="'.$user['user_id'].'">'.$user['screen_name'].'</option>';
                            }
                            ?>
                        </select>
			
                    </span>
		    <!-- Handle to Follow -->
		    <input type="text" class="" name="handle_follow" placeholder="Handle to follow" onfocus="this.value = '';" value="<?php echo ($savedSettings[0]['handle_follow']) ? $savedSettings[0]['handle_follow'] : $savedSettings[0]['user_id'] ?>">
                    
		    <!-- Empty Mode -->
		    <span>
			<?php
			$emptyChecked = "";
			if(emptyMachine() === TRUE) $emptyChecked = "checked";
			
			echo '<label>Empty Mode is On</label>';
			echo '<input type="checkbox" name="empty" '.$emptyChecked.' value="1">';
			?>
		    </span>
                    <!-- Save Settings -->
                    <input type="submit" value="Save Settings" class="btn-outline-inverted">
			<a style="display: block" href="stats.php">View Statistics</a>
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