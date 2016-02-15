<?php

/**
 * Usefull links
 * https://dev.twitter.com/overview/api/response-codes
 */

//Get access to the Twitter Library
require_once('twitteroauth/twitteroauth/twitteroauth.php');
//require_once('twitteroauth/autoload.php');
require_once('twitteroauth/config.php');
require_once('replies.php');

//use Abraham\TwitterOAuth\TwitterOAuth;


/*************************/
/*     KEY ENCODING      */
/*************************/
function get_key_encoded(){
            
	//Encode Consumer & Secret Key
	$key_encoded = base64_encode(CONSUMER_KEY.":".CONSUMER_SECRET);
	//$key_encoded = "MEsxU3JhNnQxcVcweFRVSmFVYWJ3OmgzT3FYNlhDTlBUVmk4ZzhJbmI3TFNPZXBGOWJyaU5ldFlHOEk2U1RFcw==";
         
	return $key_encoded;   
}

/*
 *
POST /oauth2/token HTTP/1.1
Host: api.twitter.com
User-Agent: My Twitter App v1.0.23
Authorization: Basic eHZ6MWV2R ... o4OERSZHlPZw==
Content-Type: application/x-www-form-urlencoded;charset=UTF-8
Content-Length: 29
Accept-Encoding: gzip

grant_type=client_credentials

**/

/*****************************/
/*     Invalidate Token      */
/*****************************/
function invalidateToken(){
        // Header settings
        $invalidate_header_settings = array(
          'http'=>array(
            'method'=>"POST",
            'header'=>  "Host: api.twitter.com\r\n".
                        "User-Agent: My Twitter App v1.0.23\r\n".
                        "Authorization: Basic $key_encoded"
          )
        );
        
        $invalidate_context = stream_context_create($invalidate_header_settings);
        // Open the file using the HTTP headers set above
        $invalidate_file = file_get_contents('https://api.twitter.com/oauth2/invalidate_token?access_token='.$bearer_token, false, $invalidate_context);
        
        //Isolate the Bearer Token
        $invalidate_json_response = json_decode($invalidate_file);
        $bearer_token = $invalidate_json_response->access_token;
        
        echo "<h2>Invalidate Token</h2>";
        //printl($bearer_token);
}

/*****************************/
/*      Get the Token        */
/*****************************/
if(isset($_GET["gettoken"]) && !empty($_GET["gettoken"])) getToken();
function getToken($print = true){
	
	$bearer_token = get_saved_token();
	
	if(!$bearer_token || $bearer_token === 'neo'){
		

		$key_encoded = get_key_encoded();
		
		// Header settings
		$header_settings_curl = array(
					"Host: api.twitter.com",
					"User-Agent: Tweets for Treats v1.1",
					"Authorization: Basic $key_encoded",
					"Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
		);
	    
            	    
            // Open the file using the HTTP headers set above
            //$file = file_get_contents('https://api.twitter.com/oauth2/token?grant_type=client_credentials', false, $context);
            $file = get_content_curl_post('https://api.twitter.com/oauth2/token', "grant_type=client_credentials", 1, $header_settings_curl);
            
	    
            if($file){
                //Isolate the Bearer Token
                $bearer_token = $file->access_token;
		
		//saveToFile("token", $bearer_token);
		saveToken($bearer_token);
            }
	    
	}
            
            if($print)  echo "<token>".$bearer_token."</token>";
            else return $bearer_token;

}

/**
 * CURL make POST request
 * 
 * $request = String - url
 * $fields = String - the fields (e.g: var=1&var_two=2)
 * $nbr_of_fields = INT - number of fields
 * $header = Array - Http header
 */
function get_content_curl_post($request, $fields, $nbr_of_fields, $header, $json = TRUE){
	//Check that CURL is loaded
	if(extension_loaded("curl")){
		//  Initiate curl
		$curlInit = curl_init();
		// Add header
		curl_setopt($curlInit, CURLOPT_HTTPHEADER, $header);
		// Make it a POST
		curl_setopt($curlInit, CURLOPT_POST, true);
		//curl_setopt($curlInit, CURLOPT_POST, $nbr_of_fields);
		curl_setopt($curlInit, CURLOPT_POSTFIELDS, $fields);
		// Disable SSL verification
		curl_setopt($curlInit, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($curlInit, CURLOPT_URL, $request);
		// Execute
		$result = curl_exec($curlInit);
		if($json){
			//set to true if wants array instead of objects ($result, true)
			$json_output = json_decode($result);
			curl_close($curlInit);
			return $json_output;
		}else{
			curl_close($curlInit);
			return $result;
		}
    
	}
}

/**
 * CURL make GET request
 * 
 * $request = String - url with fields, like a normal GET request
 * $header = Array - Http header
 */
function get_content_curl($request, $header){
	//Check that CURL is loaded
	if(extension_loaded("curl")){
		//  Initiate curl
		$curlInit = curl_init();
		// Add header
		curl_setopt($curlInit, CURLOPT_HTTPHEADER, $header);
		// Disable SSL verification
		curl_setopt($curlInit, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($curlInit, CURLOPT_URL, $request);
		// Execute
		$result=curl_exec($curlInit);
		
		//set to true if wants array instead of objects ($result, true)
		$json_output = json_decode($result);
		
		//printl($json_output);
		
		curl_close($curlInit);
		return $json_output;
    
	}
}
/*****************************/
/*     Make API Request      */
/*****************************/
function apiRequest($query, $token){
        if($token){
            // Header Setting 
            $API_header_Settings = array(
					"Host: api.twitter.com",
					"User-Agent: Tweets for Treats v1.1",
					"Authorization: Bearer ".$token
            );
            
            // Open the file using the HTTP headers.
            $API_file = get_content_curl($query, $API_header_Settings);
            
            if($API_file) return $API_file;
            else return false;
        }else{
            return false;
        }
}

/*****************************/
/*       Send Tweet          */
/*   Wrote all by myself :)  */
/*****************************/
if(isset($_GET['sendtweet']) && !empty($_GET['sendtweet'])){
    $message = " Hello Hello";
    $recipient = "littlepeacebell";
    sendNoDuplicatesTweets($recipient, $message);
}
/**
 * Send No Duplicated Tweets
 * $recipient = twitter handle(without @)
 * $message = tweet (less than 112 char)
 * Avoid Duplicates with a recursive function.
 * If message is a duplicate, add extra exclamation marks
 */
function sendNoDuplicatedTweets($recipient, $message){
	$result = sendTweet($recipient, $message);
    //printl($result);
    if($result->errors[0]->code == 187){
        $message = $message."!";
        sendNoDuplicatedTweets($recipient, $message);
    }
}

/**
 * Send a Tweet
 * $recipient = twitter handle(without @)
 * $message = tweet (less than 112 char)
 */
function sendTweet($recipient, $message){
	
	$userDetails = get_user_details();
	
	if($userDetails){
		
		$userToken = $userDetails[0]['oauth_token'];
		$userSecretToken = $userDetails[0]['oauth_token_secret'];
            
		$tweet = '@'.$recipient.' '.$message;
		
		$oauth_nonce = base64_encode(str_shuffle('qwertyuiop1234567890asdfghjklxzn'));
		
		date_default_timezone_set('Europe/London');
		$date = new DateTime();
		$oauth_timestamp =  $date->getTimestamp();
			
		$url = "https://api.twitter.com/1.1/statuses/update.json";
			
		//All Parameters
		$params = array(
			"include_entities" => "true",
			"oauth_consumer_key" => CONSUMER_KEY,
			"oauth_nonce" => $oauth_nonce,
			"oauth_signature_method" => "HMAC-SHA1",
			"oauth_timestamp" => $oauth_timestamp,
			"oauth_token" => $userToken,
			"oauth_version" => "1.0",
			"status" => $tweet
		);
		//Encode Params and build string
		$encodedString = '';
		foreach($params as $key => $value){
			$ampersand = '&';
			if($key == "status") $ampersand = '';
			$encodedString .= rawurlencode($key).'='.rawurlencode($value).$ampersand;
		}
		
		//Create Signature base string
		$oauth_signature_base_string = "POST&".rawurlencode($url)."&".rawurlencode($encodedString);
		
		
		//Create the Signing key
		$oauth_signing_key = rawurlencode(CONSUMER_SECRET).'&'.rawurlencode($userSecretToken);
		
		
		//Create signature
		$oauth_signature = base64_encode(hash_hmac('sha1', $oauth_signature_base_string, $oauth_signing_key, 'secret'));
	
		
		//Build Authorization
		$autho_params = array(
			"oauth_consumer_key" => CONSUMER_KEY,
			"oauth_nonce" => $oauth_nonce,
			"oauth_signature" => $oauth_signature,
			"oauth_signature_method" => "HMAC-SHA1",
			"oauth_timestamp" => $oauth_timestamp,
			"oauth_token" => $userToken,
			"oauth_version" => "1.0"
		);
		$autho_string = "OAuth ";
		foreach($autho_params as $key => $value){
			$endbit = ', ';
			if($key == "oauth_version") $endbit = '';
			$autho_string .= rawurlencode($key).'='.'"'.rawurlencode($value).'"'.$endbit;
		}
		
		
		// Header settings
		$header_settings_curl = array(
						"Host: api.twitter.com",
						"User-Agent: Tweets for Treats v1.1",
						'Authorization: '.$autho_string,
						"Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
		);
		
		$file = get_content_curl_post('https://api.twitter.com/1.1/statuses/update.json', "include_entities=true&status=".rawurlencode($params["status"]), 2, $header_settings_curl);
        return $file;
    }
}


/*
 * Favourite a Tweet
 * id = Tweet ID
 */
function favouriteTweet($tweet_id){
	$userDetails = get_user_details();
	
	if($userDetails){
    
        $userToken = $userDetails[0]['oauth_token'];
		$userSecretToken = $userDetails[0]['oauth_token_secret'];
        
        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $userToken, $userSecretToken);
        //$content = $connection->get('account/verify_credentials');//test
        
        $content = $connection->post('favorites/create', array('id' => $tweet_id));
        return $content;

    }
}

/*
 * Check friendships
 * $person = screen_name of the person using the machine
 * return Boolean
 */
function friendships($person){
	$userDetails = get_user_details();
	if($userDetails){
        $userToken = $userDetails[0]['oauth_token'];
		$userSecretToken = $userDetails[0]['oauth_token_secret'];
        $userScreenName = $userDetails[0]['screen_name'];
        $userId = $userDetails[0]['user_id'];
        
        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $userToken, $userSecretToken);
        //$content = $connection->get('followers/list', array('screen_name' => $userScreenName));//test
        //$content = $connection->get('users/show', array('screen_name' => 'abraham'));
        //$content = $connection->get("search/tweets", array("q" => "twitterapi"));
        //printl($connection);
        
        $relationship = FALSE;
        
        $content = $connection->get('friendships/lookup', array('screen_name' => $userId, $person));
        //$content = $connection->get('friendships/lookup', array('screen_name' => 'IWantTreats, littlepeacebell'));
        //$content = $connection->get('followers/ids', array('screen_name' => $userScreenName));
        
        //printl($connection->get('account/verify_credentials'));
        
        if(!isset($content->errors)){
            if($content[0]->connections[0] == "followed_by") $relationship = TRUE;
        }
        
        return $relationship;
    }
}

/*
 * TwitterAuth Test
 */
if(isset($_GET['testlib'])) testLib($_GET['testlib']);
function testLib($person){
	$userDetails = get_user_details();
	if($userDetails){
        $userToken = $userDetails[0]['oauth_token'];
		$userSecretToken = $userDetails[0]['oauth_token_secret'];
        $userScreenName = $userDetails[0]['screen_name'];
        $userId = $userDetails[0]['user_id'];
        
        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $userToken, $userSecretToken);
        //$content = $connection->get('followers/list', array('screen_name' => $userScreenName));//test
        //$content = $connection->get('users/show', array('screen_name' => 'abraham'));
        //$content = $connection->get("search/tweets", array("q" => "twitterapi"));
        //printl($connection);
        
        $relationship = FALSE;
        
        $content = $connection->get('friendships/lookup', array('screen_name' => $userId, $person));
        //$content = $connection->get('friendships/lookup', array('screen_name' => 'IWantTreats, littlepeacebell'));
        //$content = $connection->get('followers/ids', array('screen_name' => $userScreenName));
        printl($content);
        //printl($connection->get('account/verify_credentials'));
        
        
    }
}

/*
 * Check friendships & save to db if following to reduce API calls
 * $person = user_id of the person using the machine
 * $tableName = table to check (tweetsfortreats_people or tweetsfortreats_people_website)
 * return Boolean
 */
//if(isset($_GET['person'])) friends($_GET['person']);
function friends($person, $tableName = 'tweetsfortreats_people'){
    $friend = FALSE;
    $f = selectDataDB(array('following'), 'user_id', "'".$person."'", $tableName);
    if($f[0]['following'] == NULL){
        $follow = friendships($person);
        //var_dump($follow);
        if($follow){
        //mark as following in db
        updateGeneralDB(array('following' => 1), 'user_id', "'".$person."'", $tableName);                       
        $friend = TRUE;
        }
    }else{
        $friend = TRUE;
    }
}

/*
 * Send Direct message
 * $person = screen_name of the person using the machine
 * $message = the mesage
 * return Boolean
 */
function directMessage($person){
	$userDetails = get_user_details();
	
	if($userDetails){
    
        $userToken = $userDetails[0]['oauth_token'];
		$userSecretToken = $userDetails[0]['oauth_token_secret'];
        
        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $userToken, $userSecretToken);
        //$content = $connection->get('account/verify_credentials');//test
        
        $relationship = FALSE;
        
        //$content = $connection->post('direct_messages/new', array('screen_name' => $person, 'text' => $message));
        
    }
}


/*****************************/
/*  AUTHORIZE APP WITH USER  */
/*****************************/
if(isset($_GET['auth']) && !empty($_GET['auth'])) authorizeApp();

function authorizeApp(){
	
	$oauth_nonce = base64_encode(str_shuffle('qwertyuiop1234567890asdfghjklxzn'));
	
	$date = new DateTime();
	$oauth_timestamp =  $date->getTimestamp();
		
	$url = "https://api.twitter.com/oauth/request_token";

	
	//All Parameters
	$params = array(
		"oauth_callback" => OAUTH_CALLBACK,
		"oauth_consumer_key" => CONSUMER_KEY,
		"oauth_nonce" => $oauth_nonce,
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => $oauth_timestamp,
		"oauth_version" => "1.0",
	);
	//Encode Params and build string
	$encodedString = '';
	foreach($params as $key => $value){
		$ampersand = '&';
		if($key == "oauth_version") $ampersand = '';
		$encodedString .= rawurlencode($key).'='.rawurlencode($value).$ampersand;
	}
	
	//Create Signature base string
	$oauth_signature_base_string = "POST&".rawurlencode($url)."&".rawurlencode($encodedString);
	
	//printl($oauth_signature_base_string);
	
	//Create the Signing key
	$oauth_signing_key = rawurlencode(CONSUMER_SECRET);
	
	
	//Create signature
	$oauth_signature = base64_encode(hash_hmac('sha1', $oauth_signature_base_string, $oauth_signing_key, 'secret'));
	//$oauth_signature = base64_encode(hash_hmac('sha1', $oauth_signature_base_string, $oauth_signing_key, TRUE));
	
	//printl(rawurlencode($oauth_signature));
	
	//Build Authorization for Header
	$autho_params = array(
		"oauth_consumer_key" => CONSUMER_KEY,
		"oauth_nonce" => $oauth_nonce,
		"oauth_signature" => $oauth_signature,
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => $oauth_timestamp,
		"oauth_version" => "1.0"
	);
	$autho_string = "OAuth ";
	foreach($autho_params as $key => $value){
		$endbit = ', ';
		if($key == "oauth_version") $endbit = '';
		$autho_string .= rawurlencode($key).'='.'"'.rawurlencode($value).'"'.$endbit;
	}
	
	//printl($autho_string);
	
	// Header settings
	$header_settings_curl = array(
					"Host: api.twitter.com",
					"User-Agent: Tweets for Treats v1.1",
					"Authorization: ".$autho_string,
					"Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
	);

	$file = get_content_curl_post('https://api.twitter.com/oauth/request_token', "oauth_callback=".rawurlencode(OAUTH_CALLBACK), 1, $header_settings_curl, FALSE);
	
	//var_dump($file);
}


/*****************************/
/*      Search Twitter       */
/*****************************/

function searchTwitter($result_type, $count, $since_id, $hastag = NULL){

    //$since_id = NULL;
    if($since_id == NULL) $since_id = 0;
	    
	//Set Search using the saved settings
	$savedSettings = get_settings("settings");
	if($hastag == NULL) $q = '%23'.$savedSettings[0]['hashtag'];
	else $q = '%23'.$hastag;
	
	$token = getToken(false);
	
    
    //printl($user_name);
    
    
    //Search Hashtag and Handle
    $user_name = "IWantTreats"; //for website query
    if(ARDUINO){
        $user_details = get_user_details();
        $user_name = $user_details[0]["screen_name"];
    }
    
    $query = "https://api.twitter.com/1.1/search/tweets.json?q=%40$user_name%20$q&result_type=$result_type&count=$count&since_id=$since_id";
	
    
    //Search just a Hashtag
	//$query = "https://api.twitter.com/1.1/search/tweets.json?q=$q&result_type=$result_type&count=$count&since_id=$since_id";
	
    
	$response = apiRequest($query, $token);
    
	if($response){
	
		//echo "<hashtag>".$savedSettings['hashtag']."</hashtag>";
		$nbrTweets = count($response->statuses);
		//Use since_id_str if there's no tweets
		$since_id = ($nbrTweets > 0) ? $response->search_metadata->max_id_str : $response->search_metadata->since_id_str;
		
        //printl($response);
        
		//ARDUINO
		if(ARDUINO){
			
            //Grab all replies
            $first_replies = arduino_first_replies();
            $second_replies_not_following = arduino_second_replies_not_following();
            $second_replies_following = arduino_second_replies_following();
            $replies = arduino_replies();
            $max_replies = max_replies_arduino();
            
            if($nbrTweets > 0){  
                
                //Add people into an array to only send one tweet per person
                $peopleAlreadyRepliedToo = array();
                //Credits for the machine, 1 tweet = 1 credit
                $credits_for_machine = 0;
                
                //printl($response);
                
                //Reply to users & favourite their tweet.
				foreach($response->statuses as $tweet){
                    
                    //Check if that person already got a reply (in case there's multiple tweets from the same person)
                    if(!in_array($tweet->user->id, $peopleAlreadyRepliedToo)){
                        
                        
                        //Store peoples's handle & id in database for replies
                        $peopleDetails = array(
                            "user_id" => $tweet->user->id,
                            "screen_name" => $tweet->user->screen_name,
                            "nbr_tweets" => 1,
                            "nbr_tweets_alltime" => 1,
                            "created_at" => strtotime($tweet->created_at)
                        );
                        
                        //If people already exist, the above array will be ignored
                        savePeople($peopleDetails, 'tweetsfortreats_people');
                    
                        //Check how many times that person tweeted
                        $user_nbr_tweets_array = selectDataDB(array('nbr_tweets'), 'user_id', $tweet->user->id, 'tweetsfortreats_people');
                        $user_nbr_tweets = $user_nbr_tweets_array[0]['nbr_tweets'];
                        
                        
                        //Only bother if the person tweeted less the maximum allowed
                        if($user_nbr_tweets <= $max_replies){
                            
                            //Always favourite tweets by the user
                            //favouriteTweet($tweet->id);
                            
                            if($user_nbr_tweets == 1){
                                //Grab a random reply based on the number of times that person tweeted
                                $reply = $first_replies[array_rand($first_replies)];
                                //Reply to user
                                sendNoDuplicatedTweets($tweet->user->screen_name, $reply);
                            }
                            if($user_nbr_tweets == 2){
                                //Grab a random reply based on the number of times that person tweeted & if following
                                //if(friends($tweet->user->screen_name)) $reply = $second_replies_following[array_rand($second_replies_following)];
                                //else $reply = $second_replies_not_following[array_rand($second_replies_not_following)];
                                
                                //No following requiered
                                $reply = $second_replies_following[array_rand($second_replies_following)];
                                
                                //Reply to user
                                sendNoDuplicatedTweets($tweet->user->screen_name, $reply);
                            }
                            if($user_nbr_tweets >= 3 && $user_nbr_tweets <= $max_replies){
                                //Grab a random reply based on the number of times that person tweeted
                                $reply = $replies[$user_nbr_tweets][array_rand($replies[$user_nbr_tweets])];
                                /*
                                //check if been reminded
                                $reminded = selectDataDB(array('reminder'), 'user_id', $tweet->user->id, 'tweetsfortreats_people');
                                //Check if the person is following
                                if(!$reminded[0]['reminder'] === NULL){
                                    if(friends($tweet->user->screen_name)) sendNoDuplicatedTweets($tweet->user->screen_name, $reply);
                                //If not following just send one reminder
                                }else {
                                    sendNoDuplicatedTweets($tweet->user->screen_name, notFollowingReply());
                                    //mark as reminded in db
                                    updateGeneralDB(array('reminder' => 1), 'user_id', $tweet->user->id, 'tweetsfortreats_people');
                                }
                                */
                                
                                //No following requiered
                                sendNoDuplicatedTweets($tweet->user->screen_name, $reply);
                            }
                            
                            //Store person in array so we don't reply to him again (in case there's multiple tweets from the same person) 
                            $peopleAlreadyRepliedToo[] .= $tweet->user->id;
                            //Keep count of number of tweets, except the one that exceded the max number of replies
                            $credits_for_machine += 1;
                        }
                    }
                    
				}
			}
            
            echo "<nbr_tweets>".$credits_for_machine."</nbr_tweets>";
			echo "<max_id_str>".$since_id."</max_id_str>";
            
		}
		//WEBSITE
		else{
			
            $replies = website_replies();
            $statuses_data = array();
            
			if($nbrTweets > 0){
				$i = 0;
				//Add people into an array to only send one tweet per person
                $peopleAlreadyRepliedToo = array();
                foreach($response->statuses as $tweet){
				    //Check if that person already got a reply (in case there's multiple tweets from the same person)
                    if(!in_array($tweet->user->id, $peopleAlreadyRepliedToo)){
                        
                        //Store peoples's handle & id in database for replies
                        $peopleDetails = array(
                            "user_id" => $tweet->user->id,
                            "screen_name" => $tweet->user->screen_name,
                            "nbr_tweets" => 1,
                            "nbr_tweets_alltime" => 1,
                            "created_at" => strtotime($tweet->created_at)
                        );
                        //If people already exist, the above array will be ignored
                        savePeople($peopleDetails, 'tweetsfortreats_people_website');
                        
                        //Check how many times that person tweeted
                        $user_nbr_tweets_array = selectDataDB(array('nbr_tweets'), 'user_id', $tweet->user->id, 'tweetsfortreats_people_website');
                        $user_nbr_tweets = $user_nbr_tweets_array[0]['nbr_tweets'];
                        
                        //If user replies is superior of the number of replies, cap the value
                        if($user_nbr_tweets >= count($replies)) $user_nbr_tweets = count($replies);
                
                        //Grab a random reply based on the number of times that person tweeted
                        $reply = $replies[$user_nbr_tweets][array_rand($replies[$user_nbr_tweets])];
                        //$reply = str_shuffle('qwertyuiop1234567890asdfghjklxzn');
                       
                        //Favourite only the first tweet by the user
                        if($user_nbr_tweets == 1) $errorFav = favouriteTweet($tweet->id);
                            
                        //Reply to user
                        $errorSend = sendNoDuplicatedTweets($tweet->user->screen_name, $reply);
                        
                        //Do stuff
                        $statuses_data[$i]["tweet_id"] = $tweet->id;
                        $statuses_data[$i]["message"] = $tweet->text;
                        $statuses_data[$i]["username"] = $tweet->user->screen_name;
                        $statuses_data[$i]["error"] = array("fav" => $errorFav, "send" => $errorSend);

                        $i++;

                        //Store person in array so we don't reply to him again (in case there's multiple tweets from the same person)
                        $peopleAlreadyRepliedToo[] .= $tweet->user->id;
                    }
				}
			}
			$return_data = array(
				"nbr_tweets" => count($peopleAlreadyRepliedToo),
				"since_id" => $since_id,
				"statuses" => $statuses_data
			);
			return $return_data;
		}
		
        }
        
}


/**
 * Arduino queries
 *
 **/
function arduino_get_queries(){
    if(isset($_GET["treats"]) && !empty($_GET["treats"])){
        //API REQUEST
        if(isset($_GET["result_type"])){
            //searchTwitter($_GET["result_type"], $_GET["count"], $_GET["since_id"], urlencode($_GET["token"]));
            searchTwitter($_GET["result_type"], $_GET["count"], $_GET["since_id"]);
            //Exit php as we don't want to send back the rest the page
            exit;
        }
        //GET TOKEN
        /* if(isset($_GET["gettoken"])){
            echo getToken();
        //Exit php as we don't want to send back teh rest the page
        exit;
        }*/  
    }
}


/**
 * Website queries
 * http://www.domainName.com/treats/web.php?results=5&hashtag=worlddomination&since_id=1234567890
 * results (requiered): nbr_of_tweets, minimun is 1
 * since_id: first time is not needed but you need to keep the one returned for the next query so you only get new tweets since the last one.
 * hashtag: if you want to test with an hastag that is not the one set for the arduino (don't need to write the '#', just the word)
 *
 **/

/*POST*/
function website_post_queries(){
	if(isset($_POST["results"]) && !empty($_POST["results"])){
		$hashtag = NULL;
		if(isset($_POST["hashtag"]) && !empty($_POST["hashtag"])) $hashtag = $_POST["hashtag"];
		$response = searchTwitter("recent", $_POST["results"], $_POST["since_id"], $hashtag);
		if($response) {
			//Header('Content-type: text/javascript; charset=UTF-8');
			echo json_encode($response);
		}
		//Exit php as we don't want to send back the rest the page
		exit;
	}
}


/*GET*/
function website_get_queries(){
	if(isset($_GET["results"]) && !empty($_GET["results"])){
		$hashtag = NULL;
		if(isset($_GET["hashtag"]) && !empty($_GET["hashtag"])) $hashtag = $_GET["hashtag"];
		$response = searchTwitter("recent", $_GET["results"], $_GET["since_id"], $hashtag);
		if($response) {
			//Header('Content-type: text/javascript; charset=UTF-8');
			echo json_encode($response);
		}
		//Exit php as we don't want to send back the rest the page
		exit;
	}
}

if(ARDUINO){
    arduino_get_queries();
}else{
    website_post_queries();
    website_get_queries();
}
?>