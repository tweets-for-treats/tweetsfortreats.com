<?php

define('URL', 'http://www.tweetsfortreats.com');
define('HOST', 'internal-db.s179275.gridserver.com');

//Reset Machine
resetPeopleNbrTweets('tweetsfortreats_people');
//Rest Website
resetPeopleNbrTweets('tweetsfortreats_people_website');


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

?>