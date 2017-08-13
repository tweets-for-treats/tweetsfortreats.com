<?php

/* usefull info
 * https://dev.twitter.com/docs/auth/authorizing-request
 *
 *
 *
 *
 *
 **/

require_once('utilities.php');
require_once('twitteroauth/twitteroauth/twitteroauth.php');
require_once('twitteroauth/config.php');

//Start the Session if it hasn't been started already
if(!isset($_SESSION)) session_start();

//session_destroy();


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
	
	$bearer_token = get_settings("token");
	
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
		saveSettings("token", $bearer_token);
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
/*****************************/
if(isset($_GET['sendtweet']) && !empty($_GET['sendtweet'])){
	sendTweet("@littlepeacebell", " Hello Hello");
}
function sendTweet($author, $message){
	
	$tweet = $author.$message;
	
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
		"oauth_token" => OAUTH_ACCESS_TOKEN,
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
	$oauth_signing_key = rawurlencode(CONSUMER_SECRET).'&'.rawurlencode(OAUTH_ACCESS_TOKEN_SECRET);
	
	
	//Create signature
	$oauth_signature = base64_encode(hash_hmac('sha1', $oauth_signature_base_string, $oauth_signing_key, 'secret'));

	
	//Build Authorization
	$autho_params = array(
		"oauth_consumer_key" => CONSUMER_KEY,
		"oauth_nonce" => $oauth_nonce,
		"oauth_signature" => $oauth_signature,
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => $oauth_timestamp,
		"oauth_token" => OAUTH_ACCESS_TOKEN,
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
function searchTwitter($result_type, $count, $since_id){
        if($since_id == NULL) $since_id = 0;
	
	//Set Search using the saved settings
	$savedSettings = get_settings("settings");
	$q = '%23'.$savedSettings['hashtag'];
	$token = getToken(false);
	
	$query = "https://api.twitter.com/1.1/search/tweets.json?q=$q&result_type=$result_type&count=$count&since_id=$since_id";
        
	$response = apiRequest($query, $token);
        if($response){
	
		//echo "<hashtag>".$savedSettings['hashtag']."</hashtag>";
		
		$nbrTweets = count($response->statuses);
		echo "<nbr_tweets>".$nbrTweets."</nbr_tweets>";
		
		//Use since_id_str if there's no tweets
		$since_id = ($nbrTweets > 0) ? $response->search_metadata->max_id_str : $response->search_metadata->since_id_str;
		echo "<max_id_str>".$since_id."</max_id_str>";
		
		if($nbrTweets > 0){
			//Arduino will be needed this if printing
			echo "<statuses>";
			foreach($response->statuses as $tweet){
			    echo "<tweet>";
			    //echo "<id>".$tweet->id."</id>";
			    echo "<message>".$tweet->text."</message>";
			    echo "<username>".$tweet->user->screen_name."</username>";
			    echo "</tweet>";
			    }
			echo "</statuses>";
			
			//Reply to users & favourite their tweet.
			foreach($response->statuses as $tweet){
				//favouriteTweet($tweet->id);
				//sendTweet($tweet->user->screen_name, "Hello Hello");
			}
		}
		
        }
       //printl($response);
}

//Deal with the Social Box Requests
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


//Deal with Settings Requests
if(isset($_POST["hashtag"]) && !empty($_POST["hashtag"])){

	//Put in array and Remove all white spaces
	$settings = array(
		"hashtag" => preg_replace('/\s+/', '', $_POST["hashtag"]), 
		"duration" => preg_replace('/\s+/', '', $_POST["duration"])
	);
	
	saveSettings("settings", $settings);
	
}

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
	
	
	<style type="text/css">
		html, body{
			width: 100%;
			height: 100%;
			padding: 0;
			margin: 0;
		}
		body{
			color: #fffde9;
			text-align: center;
			font-size: medium;
			font-family: 'Open Sans Condensed', Arial, Verdana;
			letter-spacing: -2px;
			background: #403f38; /* Old browsers */
			background: -moz-radial-gradient(center, ellipse cover,  #605f58 0%, #2f2f29 100%); /* FF3.6+ */
			background: -webkit-radial-gradient(center, ellipse cover,  #605f58 0%,#2f2f29 100%); /* Chrome10+,Safari5.1+ */
			background: -o-radial-gradient(center, ellipse cover,  #605f58 0%,#2f2f29 100%); /* Opera 12+ */
			background: -ms-radial-gradient(center, ellipse cover,  #605f58 0%,#2f2f29 100%); /* IE10+ */
			background: radial-gradient(ellipse at center,  #605f58 0%,#2f2f29 100%); /* W3C */
		}
		#container{
			width: 25%;
			height: 90%;
			margin: 0 auto;
			padding: 10% 0 0 0;
		}
		#logo{
			margin: 10px auto;
		}
		h1{
			font-size: 165%;
			letter-spacing: 7px;
			margin: 0 auto;
		}
		form{
			width: 100%;
			padding: 0;
			margin: 0;
		}
		input, select{
			font-size: 150%;
			width: 90%;
			height: 42px;
			background:#fffde9;
			color: #403f38;
			padding: 10px 5% 5px;
			margin: 10px 0;
			border: none;
			cursor: pointer;
			outline: none;
			-webkit-appearance:none;
			-moz-appearance:none;
			appearance:none;
			-webkit-border-radius:0;
			-moz-border-radius:0;
			border-radius:0;
		}
		label {
			width: 100%;
			height: 57px;
			margin: 10px 0;
			padding: 0;
			display: block;
			position:relative;
		}
		select, option.item{
			width: 100%;
			height: 100%;
			padding: 10px 5% 5px;
			margin: 0;
			outline:none;
			display: inline-block;
		}
		/* Hide default arrow Firefox */
		select{
			text-indent: 0.5px;
			text-overflow: "";
		}
		label:after {
			content: '';
			background: #5fc3b1 url('images/arrow.png');
			background-size: 100% 100%;
			width: 52px;
			height: 100%;
			top: 0;
			right: 0;
			padding:0 0 ;
			position:absolute;
			pointer-events:none;
		}
		/*label:before {
		    content:'';
		    position:absolute;
		    pointer-events:none;
		    display:block;
		}*/
		select option.item{
			font-size: 8pt;
		}
		input[type=submit]{
			background:#5fc3b1;
			color: #fffde9;
			height: 57px;
			width: 100%;
		}
		input[type=password]{
			letter-spacing: 2pt;
		}
		/**** MOBILE *****/
		@media screen and (max-width: 1000px) {
			body{
				overflow: hidden;	
			}
			#container{
				width: 70%;
			}
			h1{
				font-size: 160%;
			}
			input, select{
			    font-size: 160%;
			}
		}
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
	<?php errorPrint() ?>
	<div id="container">
		<img id="logo" src="images/logo.png" width=44 height=44/>
		<h1>TREATS FOR TREATS</h1>
		<?php if(isset($_SESSION['loged']) && $_SESSION['loged']) : ?>
		<?php $savedSettings = get_settings("settings");?>
		<?php printl(get_users()); ?>
		<form id="form" action="index.php" method="post">
			<input type="text" name="hashtag" onfocus="this.value = '';" value="<?php echo ($savedSettings['hashtag']) ? $savedSettings['hashtag'] : 'enter hashtag' ?>">
			<label><select name="duration">
				<?php
				for($i=1; $i<=10; $i++){
					echo '<option class="item" '.($savedSettings['duration'] == $i ? 'selected' : '').' value="'.$i.'">'.$i.($i==1 ? ' second' : ' seconds').'</option>';
				}
				for($i=60; $i<=600; $i+=60){
					echo '<option class="item" '.($savedSettings['duration'] == $i ? 'selected' : '').' value="'.$i.'">'.($i/60).($i==60 ? ' minute' : ' minutes').'</option>';
				}
				?>
			</select>
			</label>
			<input type="submit" value="SAVE SETTINGS">
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