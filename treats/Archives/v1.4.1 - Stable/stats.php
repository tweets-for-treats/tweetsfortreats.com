<?php
//Start the Session if it hasn't been started already
if(!isset($_SESSION)) session_start();

//session_destroy();

require_once('utilities.php');

redirectCheckMemberLogin();

$table_array = array(
          "Website" => "tweetsfortreats_people_website",
          "Machine" => "tweetsfortreats_people"
);



function count_total_user($tableName){
          $response = mysqli($tableName, "SELECT COUNT(*) FROM $tableName", FALSE);
          return $response[0][0];
}

function power_user($tableName){
          $response = mysqli($tableName, "SELECT `screen_name`, `nbr_tweets_alltime` FROM $tableName ORDER BY `nbr_tweets_alltime` DESC LIMIT 0, 1", FALSE);
          return $response[0];
}

function all_users($tableName){
          $response = mysqli($tableName, "SELECT `screen_name`, `nbr_tweets_alltime` FROM $tableName ORDER BY `nbr_tweets_alltime` DESC", FALSE);
          return $response;
}

function mysqli($tableName, $sql, $assoc = true){
          $mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
          //The query failed, reload page and ask the user to try again
	  $result = $mysqli->query($sql);
	  if(!$result){
		    $_SESSION['error'] = 'There was an error saving, please try again!';
	  }
	  //If the query worked, gather data
	  else {
                 $_SESSION['error'] = '';
                        //didn't need loop but MT doesn't support!
                        //$responseArray = $result->fetch_all(MYSQLI_ASSOC);
                        //So let's loop instead :(
                        
                        //Associative Array
                        if($assoc){
                              while($responseValue = $result->fetch_array(MYSQLI_ASSOC)){
                                        $responseArray[] = $responseValue;
                              }
                        }
                        else{
                              //Indexed Array
                              while($responseValue = $result->fetch_array(MYSQLI_NUM)){
                                        $responseArray[] = $responseValue;
                              }
                        }
                        
                              $result->close();
                              return $responseArray;
                }
	}else{
		$_SESSION['error'] = $mysqli;
	}
	$mysqli->close();
}
?>

<!DOCTYPE html>

<html>
          <head>
                    <title>Tweets for Treats - Statistics</title>
                    
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
                                        <div id="logo"><img src="../img/tweets-for-treats-logo-white.svg"></div>
                                        <a style="display: block; text-align: center; margin: 20px auto;" href="index.php">View Settings</a>
                                        <div class="stats-panel">
                                                  <!-- Stats -->
                                                  <?php foreach($table_array as $key=>$table) : ?>
                                                        <div class="stat-block">
                                                            <h3><?php echo $key ?> Stats</h3>
                                                            <?php $total_users = count_total_user($table) ?>
                                                            <p>There have been <?php echo $total_users ?> users in total</p>
                                                            
                                                            <?php if($total_users>0): ?>
                                                            <?php $power_user = power_user($table);?>
                                                            <p> <a href="http://twitter.com/<?php echo $power_user[0]?>" target="_blank"><?php echo $power_user[0]?></a> is our power user with <?php echo $power_user[1]?> tweets</p>
                                                            <h4>All users (high to low activity):</h4>
                                                            <?php
                                                                      $all_users = all_users($table);
                                                                      echo "<ol>";
                                                                      foreach($all_users as $user){
                                                                                echo '<li><a href="http://twitter.com/'.$user[0].'" target="_blank">'.$user[0].'</a> - '.$user[1].' tweets</li>';
                                                                      }
                                                                      echo "</ol>";
                                                            ?>
                                                            <?php endif; ?>
                                                        </div>
                                                  <?php endforeach; ?>
                                                  
                                                  
                                                  
                                        </div>
                              </div>
                    </section>
          </body>
          <script src="../js/jquery.1.11.1.min.js"></script>
          <script src="treats-admin.js"></script>
</html>