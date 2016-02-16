<?php
//Start the Session if it hasn't been started already
if(!isset($_SESSION)) session_start();

date_default_timezone_set('UTC');

require_once("twitteroauth/config.php");
require_once("twitter_utilities.php");


/*********************  LOGIN CHECK ********************/
function checkMemberLogin(){
 if(isset($_SESSION['loged']) && $_SESSION['loged']) {
  return TRUE;
 }else{
  return FALSE;
 }
}

function redirectCheckMemberLogin(){
 if(!checkMemberLogin()) go_to_login();
 
}

/********************* REDIRECTS ************************/
function go_to_login(){
 header('location: login.php');
 exit;
}
function go_to_home_page(){
 header('location: index.php');
 exit;
}

/*********************  CONNECT TO DATABASE AND TABLE ********************/
function connectToDatabase($tbl_name){
 $sqlUser ="db179275";
 $sqlPassword ="?unfamous!123";
 $db_name ="db179275_tweetsfortreats";
 
 $mysqli = new mysqli(HOST, "$sqlUser", "$sqlPassword", "$db_name");
 if ($mysqli->connect_errno) {
     echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
 }else{
     return $mysqli;
 }
}


/*********************  ANTI HACKERS ********************/
function agentSmith($mysqli, $rawContent, $order = 'main'){
    
    //Check for Login
    if($order === 'main'){
        //Check For Legal Caracters
        //$charAccepted = "/^[A-Za-z0-9 \_\%\£\$\@\-]{1,1000}$/";
        $charAccepted = "/^[A-Za-z0-9 \_\%\£\$\@\-\+]{1,1000}$/";
        if(is_array($rawContent)){
         foreach($rawContent as $key => $value){
             //If it macth then populate the cleaned Array with the Raw Array Values
             if (preg_match($charAccepted, $value)) {
                 $cleaned[$key] = $value;
             //If it doesn't place neo instead of the value
             }else{
                 $cleaned[$key] = 'neo';
                 return $cleaned;
             }
         }
        }else{
         if(preg_match($charAccepted, $rawContent)){
          $cleaned = $rawContent;
         }else{
          $rawContent = 'neo';
          return $rawContent;
         }
        }
    }
    
    //If you Passed The Regular expression test, Check against MSQL Injections
    //Check if magic quotes is on ( if on it will add extra slash infront of a slash). Now off on most servers
    $magicQuotes = get_magic_quotes_gpc();
    //Escape String against injections
    $cleaned = realEscapeStringRecursive($mysqli, $magicQuotes, $cleaned);
    //Return a super cleaned Array/text
    return $cleaned;
}

/**
 * Recursive real_escape_string for Arrays
 *
 * $mysqli = $mysqli object
 * $magicQuotes = boolean (maguc quotes on or off?)
 * $content = An array or string to treat
 *
 **/
function realEscapeStringRecursive($mysqli, $magicQuotes, $content){

      if(is_array($content)){
       foreach($content as $key => $value){
          if(is_array($value)) realEscapeStringArrayRecursive($mysqli, $magicQuotes, $value); 
          else {
           //If get magic is on , clean the extra slash
           if ($magicQuotes) $content[$key] = stripslashes($value);
           $content[$key] = $mysqli->real_escape_string($value);
          }
       }
      }else{
         //If get magic is on , clean the extra slash
         if ($magicQuotes) $content = stripslashes($content);
         $content = $mysqli->real_escape_string($content);
      }
       
       return $content;
}
/*
 * Save TOKEN to DB
 */
function saveToken($content){
        $contentArray = array('token' => $content);
	updateGeneralDB($contentArray);
}
/*
 * Save Settings to DB
 */
//Deal with Settings Requests
if(isset($_POST["hashtag"]) && !empty($_POST["hashtag"])){

	//Put in array and Remove all white spaces
	$settings = array(
		"hashtag" => preg_replace('/\s+/', '', $_POST["hashtag"]), 
		"duration" => $_POST["duration"],
		"user_id" => $_POST["user_id"],
                "time_reset" => mktime($_POST["time_reset"])
	);
	saveSettings($settings);
	
}
function saveSettings($content){
       updateGeneralDB($content);
}
/*
 * Update DB
 * $content: An array that will be transformed into a string for UPDATE mysql
 */
function updateGeneralDB($content, $where = 'id', $needle = 1, $tableName = 'tweetsfortreats_general'){
	$mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
		$cleanContent = agentSmith($mysqli, $content);
		//Build SET as a String for the QUERY
                $i=0;
                foreach($cleanContent as $key=>$val){ 
                      if($i == 0) $c = $key." = '".$val."'";
                      else $c .= ', '.$key." = '".$val."'";
                      $i++;
                }

                $sql="UPDATE $tableName SET $c WHERE $where = $needle";
                //printl($sql);
                //The query failed, reload page and ask the user to try again
		$result = $mysqli->query($sql);
		if(!$result){
		    $_SESSION['error'] = 'There was an error saving, please try again!';
		}
		//If the query worked, reload page
		else $_SESSION['error'] = '';
	}else{
		$_SESSION['error'] = $mysqli;
	}
        //printl($mysqli->error);
	$mysqli->close();
}
/*
 * Save or Update Users to DB
 * $content: An array that will be transformed into a string for UPDATE mysql
 */
function saveUsers($content){
 
        if(check_exist('user_id', $content["user_id"], 'tweetsfortreats_users')){
                updateGeneralDB($content, 'user_id', $content["user_id"], 'tweetsfortreats_users');
        }
        else addToDB("oauth_token, oauth_token_secret, user_id, screen_name", $content, 'tweetsfortreats_users');

}



/*
 * Update Nrb of tweets per people in DB
 * $content: An array that will be transformed into a string for UPDATE mysql
 */
function updatePeopleNbrTweets($where = 'id', $needle = 1, $tableName = 'tweetsfortreats_people', $max = 500){
        $mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
                //$sql="UPDATE $tableName SET nbr_tweets = nbr_tweets + 1, nbr_tweets_alltime = nbr_tweets_alltime + 1 WHERE $where = $needle";
		//$sql="UPDATE $tableName SET nbr_tweets = IF(nbr_tweets < $max, nbr_tweets + 1, nbr_tweets), IF(nbr_tweets < $max, nbr_tweets_alltime + 1, nbr_tweets_alltime) WHERE $where = $needle";
		$sql="UPDATE $tableName SET nbr_tweets_alltime = IF(nbr_tweets < $max, nbr_tweets_alltime + 1, nbr_tweets_alltime), nbr_tweets = IF(nbr_tweets < $max, nbr_tweets + 1, nbr_tweets) WHERE $where = $needle";
		//printl($sql);
                //The query failed, reload page and ask the user to try again
		$result = $mysqli->query($sql);
		if(!$result){
		    $_SESSION['error'] = 'There was an error saving, please try again!';
		}
		//If the query worked, reload page
		else $_SESSION['error'] = '';
	}else{
		$_SESSION['error'] = $mysqli;
	}
	$mysqli->close();
}


/*
 * Reset Nrb of tweets and reminder for all people in Arduino DB.
 */
function resetPeopleNbrTweets($tableName = 'tweetsfortreats_people'){
	$mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
                $sql="UPDATE $tableName SET nbr_tweets = 1, reminder = NULL, following = NULL";
		//printl($sql);
                //The query failed, reload page and ask the user to try again
		$result = $mysqli->query($sql);
		if(!$result){
		    $_SESSION['error'] = 'There was an error saving, please try again!';
		}
		//If the query worked, reload page
		else $_SESSION['error'] = '';
	}else{
		$_SESSION['error'] = $mysqli;
	}
	$mysqli->close();
}

/*
 * Save or Update People to DB
 * $content: An array that will be transformed into a string for UPDATE mysql
 */
function savePeople($content, $tableName, $max = 500){
        if(check_exist('user_id', $content["user_id"], $tableName)){
                updatePeopleNbrTweets('user_id', $content["user_id"], $tableName, $max);
        }
        else addToDB("user_id, screen_name, nbr_tweets, nbr_tweets_alltime, created_at", $content, $tableName);
}
/*
 * Add to DB
 */
function addToDB($field, $content, $tableName, $exit = false){
	$mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
		$cleanContent = agentSmith($mysqli, $content);
                //Build VALUES as a String for the QUERY
                $c = '(\'';
                $i=0;
                foreach($cleanContent as $key=>$val){ 
                      if($i == 0) $c .= $val;
                      else $c .= '\', \''.$val;
                      $i++;
                }
                $c .= '\')';
                //Write infos to the database
		$sql= "INSERT INTO $tableName ($field) VALUES ".$c;
                
		//The query failed, reload page and ask the user to try again
		$result = $mysqli->query($sql);
		if(!$result){
		    $mysqli->close();
                                            $_SESSION['error'] = 'There was an error saving, please try again!';
		    if($exit){
                                             header("location:./index.php");
                                             exit;
                                            }
		}
		//If the query worked, reload page
		else{
			$mysqli->close();
                                                            $_SESSION['error'] = '';
			if($exit){
                                                             header("location:./index.php");
                                                             exit;
                                                            }
		}
	}else{
		$_SESSION['error'] = "Couldn't connect to datatbase";
			if($exit){
                                                             header("location:./index.php");
                                                             exit;
                                                            }
	}
}



 if(isset($_GET["settings"]) && !empty($_GET["settings"])){
	printl(get_settings("settings"));
 }
  if(isset($_GET["token"]) && !empty($_GET["token"])){
	printl(get_settings("token"));
 }
 /*
 * Get Token
 */
function get_saved_token(){
	return get_data_from_DB('tweetsfortreats_general', FALSE, 'token');
}
/*
 * Get the Settings
 */
function get_settings(){
	return get_data_from_DB('tweetsfortreats_general', TRUE);
}
/*
 * Get Users
 */
function get_users(){
        return get_data_from_DB('tweetsfortreats_users', TRUE);
}
function get_data_from_DB($tableName, $all = false, $field = 'id'){
        $mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
		if($all) $sql="SELECT * FROM $tableName";
                else $sql="SELECT $field FROM $tableName";
		$result = $mysqli->query($sql);
		if(!$result){
		    $_SESSION['error'] = 'There was an error getting the settings, please try again!';
		}else{
			if($all){
                                $response = array();
                                //Cycle trhough rows and store it in a array
                                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                        $response[] = $row;
                                }
                                $result->close();
                        }
                        else {
                                $responseArray = $result->fetch_row();
                          
                                $result->close();
                                $response = $responseArray[0];
                        }
                        return $response;
		}
	}else{
		$_SESSION['error'] = "Couldn't connect to datatbase";
	}
	$mysqli->close();
}
/*
 * Get specif data DB
 * $content: An array that will be transformed into a string for SELECT mysql
 */
function selectDataDB($fieldToFetch, $where = 'id', $needle = 1, $tableName = 'tweetsfortreats_general'){
	$mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
		$cleanContent = agentSmith($mysqli, $fieldToFetch);
		//Build SET as a String for the QUERY
                $i=0;
                foreach($cleanContent as $val){ 
                      if($i == 0) $c = $val;
                      else $c .= ', '.$val;
                      $i++;
                }
                $sql="SELECT $c FROM $tableName WHERE $where = $needle";
                
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
                        while($responseValue = $result->fetch_array(MYSQLI_ASSOC)){
                        //Indexed Array
                        //while($responseValue = $result->fetch_array(MYSQLI_NUM)){
                         $responseArray[] = $responseValue;
                        }
                                $result->close();
                                //$response = $responseArray[0];
                                //return $response;
                                //printl($responseArray);
                                return $responseArray;
                }
	}else{
		$_SESSION['error'] = $mysqli;
	}
	$mysqli->close();
}

/*
 * Get User details
 */
function get_user_details(){
        $tableNameUsers = 'tweetsfortreats_users';
        $tableNameGeneral = 'tweetsfortreats_general';
        $mysqli = connectToDatabase($tableNameUsers);
	if(is_object($mysqli)){
		$sql="SELECT $tableNameUsers.* FROM $tableNameUsers INNER JOIN $tableNameGeneral ON $tableNameUsers.user_id=$tableNameGeneral.user_id";
		$result = $mysqli->query($sql);
		if(!$result){
		    $_SESSION['error'] = 'There was an error getting the settings, please try again!';
                    return FALSE;
		}else{
                        $response = array();
                        while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                $response[] = $row;
                        }
                        $result->close();
                        return $response;
                }
	}else{
		$_SESSION['error'] = "Couldn't connect to datatbase";
                return FALSE;
	}
	$mysqli->close();
}

/*
 * Check a value already exist in database
 * $field = table field
 * $needle = the thing you're looking for
 * $tablename = db table name
 */
if(isset($_GET["check"]) && !empty($_GET["check"])){
	var_dump(check_exist("screen_name", "mighty_mess", "tweetsfortreats_users"));
}
function check_exist($field, $needle, $tableName){
        $mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
                $sql = "SELECT * FROM $tableName WHERE $field = '$needle'";
                $result = $mysqli->query($sql);
		if(!$result){
                        return $result;
		}else{
                        if($result->num_rows === 0) return FALSE;
                        else return TRUE;
                }
        }
}

/*
 *Print Session Error
 */
function errorPrint(){
	if($_SESSION['error']) {
		echo '<div id="phpError">';
                printl("MSQL ERROR");
		printl($_SESSION['error']);
                echo '</div>';
	}
}

/**
 * XSS Protection on data coming from fields
 **/
function xssProtect($var){
        $xssProtection = "/^[A-Za-z0-9 \,]{2,15}$/";
        if (!preg_match($xssProtection, $var)) return FALSE;
        else return $var;
}



/*********************** DEBUG ********************************/
function printl($v){
		printf("<pre>%s</pre>", print_r($v, true));
	}		