<?php
//Start the Session if it hasn't been started already
if(!isset($_SESSION)) session_start();

require_once("twitteroauth/config.php");

/*********************  LOGIN CHECK ********************/
function checkMemberLogin(){
 if(isset($_SESSION['loged']) && $_SESSION['loged']) {
  return TRUE;
 }else{
  return FALSE;
 }
}

/********************* REDIRECTS ************************/
function go_to_login(){
 header('location: index.php');
 exit;
}
function go_to_home_page(){
 header('location: index.php');
 exit;
}

/*********************  CONNECT TO DATABASE AND TABLE ********************/
function connectToDatabase($tbl_name){
 $host ="127.0.0.1";
 //$host = "internal-db.s179275.gridserver.com";
 $sqlUser ="db179275";
 $sqlPassword ="?unfamous!123";
 $db_name ="db179275_blacksuncreative";
 
 $mysqli = new mysqli("$host", "$sqlUser", "$sqlPassword", "$db_name");
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
        $charAccepted = "/^[A-Za-z0-9 \_\%\£\$\@\-]{1,1000}$/";
        
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
 * Save Settings to DB
 */
function saveSettings($field, $content){
	updateDB($field, $content, 'tweetsfortreats_general');
}
/*
 * Update DB
 */
function updateDB($field, $content, $tableName, $where = 'id', $equal = 1){
	$mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
		$cleanContent = agentSmith($mysqli, $content);
		$serializedContent = serialize($cleanContent);
		//Write infos to the database
		$sql="UPDATE $tableName SET $field = '$serializedContent' WHERE $where = $equal";
		//The query failed, reload page and ask the user to try again
		$result = $mysqli->query($sql);
		if(!$result){
		    $_SESSION['error'] = 'There was an error saving, please try again!';
		    header("location:index.php");
		    exit;
		}
		//If the query worked, reload page
		else{
			$_SESSION['error'] = '';
			header("location:index.php");
			exit;
		}
	}else{
		$_SESSION['error'] = "Couldn't connect to datatbase";
		header("location:index.php");
		exit;
	}
	$mysqli->close();
}
/*
 * Save Users to DB
 */
function saveUsers($content){
 	//updateDB($field, $content, 'tweetsfortreats_general');
        addToDB("user_id, screen_name, oauth_token, oauth_token_secret", $content, 'tweetsfortreats_users');
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
/*
 * Add to DB
 */
function addToDBSingle($field, $content, $tableName, $exit = false){
	$mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
		$cleanContent = agentSmith($mysqli, $content);
		$serializedContent = serialize($cleanContent);
		//Write infos to the database
		$sql="INSERT INTO $tableName ($field) VALUES ('$serializedContent')";
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
 * Get the Settings
 */
function get_settings($field){
	return get_data_from_DB($field, 'tweetsfortreats_general');
}
/*
 * Get Users
 */
function get_users(){
                    return get_data_from_DB('user_details', 'tweetsfortreats_users', TRUE);
}

function get_data_from_DB($field, $tableName, $all = false){
        $mysqli = connectToDatabase($tableName);
	if(is_object($mysqli)){
		if($all) $sql="SELECT * FROM $tableName";
                else $sql="SELECT $field FROM $tableName";
		$result = $mysqli->query($sql);
		if(!$result){
		    $_SESSION['error'] = 'There was an error getting the settings, please try again!';
		    $result->close();
		    header("location:index.php");
		    exit;
		}else{
			if($all){
                                                             $response = array();
                                                             while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                                              $response[] = $row;
                                                             }
                                                             $result->close();
                                                             return($response);
                                                            }
                                                            else {
                                                             $responseArray = $result->fetch_row();
                                                             $result->close();
                                                             $response = unserialize($responseArray[0]);
                                                            }
                                                            return $response;
		}
	}else{
		$_SESSION['error'] = "Couldn't connect to datatbase";
		header("location:index.php");
		exit;
	}
	$mysqli->close();
}




/*
 *Print Session Error
 */
function errorPrint(){
	if($_SESSION['error']) {
		printl("MSQL ERROR");
		printl($_SESSION['error']);
	}
}

/*********************** DEBUG ********************************/
if(!function_exists(printl)){
	function printl($v){
		printf("<pre>%s</pre>", print_r($v, true));
	}		
}