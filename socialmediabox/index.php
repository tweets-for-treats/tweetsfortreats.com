<?php

//Start the Session if it hasn't been started already
if(!isset($_SESSION)) session_start();

//session_destroy();

/******** debug ********/
if(!function_exists(printl)){
	function printl($v){
		printf("<pre>%s</pre>", print_r($v, true));
	}		
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
        printl($bearer_token);
}

/*****************************/
/*      Get the Token        */
/*****************************/
function getToken($print = true){
            $bearer_token = false;
            $consumer_key = "0K1Sra6t1qW0xTUJaUabw";
            $consumer_secret_key = "h3OqX6XCNPTVi8g8Inb7LSOepF9briNetYG8I6STEs";
            
            //Encode Consumer & Secret Key
            $key_encoded = base64_encode($consumer_key.":".$consumer_secret_key);
            $key_encoded = "MEsxU3JhNnQxcVcweFRVSmFVYWJ3OmgzT3FYNlhDTlBUVmk4ZzhJbmI3TFNPZXBGOWJyaU5ldFlHOEk2U1RFcw==";
            
            // Header settings
            $header_settings_old = array(
              'http'=>array(
                'method'=>"POST",
                'header'=>  "Host: api.twitter.com\r\n".
                            "User-Agent: My Twitter App v1.0.23\r\n".
                            "Authorization: Basic $key_encoded \r\n".
                            "Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
              )
            );
            //$context = stream_context_create($header_settings);
	    
		// Header settings
		$header_settings_curl = array(
					"Host: api.twitter.com",
					"User-Agent: My Twitter App v1.0.23",
					"Authorization: Basic $key_encoded",
					"Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
		);
	    
            
	    //printl($header_settings);
	    
            // Open the file using the HTTP headers set above
            //$file = file_get_contents('https://api.twitter.com/oauth2/token?grant_type=client_credentials', false, $context);
            $file = get_content_curl_post('https://api.twitter.com/oauth2/token', "grant_type=client_credentials", 1, $header_settings_curl);
            
	    
            if($file){
                //Isolate the Bearer Token
                $bearer_token = $file->access_token;
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
function get_content_curl_post($request, $fields, $nbr_of_fields, $header){
	//Check that CURL is loaded
	if(extension_loaded("curl")){
		//  Initiate curl
		$curlInit = curl_init();
		// Add header
		curl_setopt($curlInit, CURLOPT_HTTPHEADER, $header);
		// Make it a POST
		curl_setopt($curlInit, CURLOPT_POST, $nbr_of_fields);
		curl_setopt($curlInit, CURLOPT_POSTFIELDS, $fields);
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
					"User-Agent: My Twitter App v1.0.23",
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
/*      Search Twitter       */
/*****************************/
function searchTwitter($q, $result_type, $count, $since_id, $token){
        if($since_id == NULL) $since_id = 0;
	
	//Set Search using the saved settings
	$savedSettings = get_settings();
	$q = '%23'.$savedSettings['hashtag'];
	
	
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
			echo "<statuses>";
			foreach($response->statuses as $tweet){
			    echo "<tweet>";
			    echo "<id>".$tweet->id."</id>";
			    echo "<message>".$tweet->text."</message>";
			    echo "<username>".$tweet->user->screen_name."</username>";
			    echo "</tweet>";
			    }
			echo "</statuses>";
		}
        }
       //printl($response);
}

//Deal with the Social Box Requests
if(isset($_GET["socialbox"]) && !empty($_GET["socialbox"])){
    //API REQUEST
    if(isset($_GET["q"])){
        searchTwitter(urlencode($_GET["q"]), $_GET["result_type"], $_GET["count"], $_GET["since_id"], urlencode($_GET["token"]));
	//Exit php as we don't want to send back the rest the page
	exit;
    }
    //GET TOKEN
    if(isset($_GET["gettoken"])){
        echo getToken();
	//Exit php as we don't want to send back teh rest the page
	exit;
    }
    
}


//Deal with Settings Requests
if(isset($_POST["hashtag"]) && !empty($_POST["hashtag"])){

	$settings = array(
		"hashtag" => $_POST["hashtag"], 
		"duration" => $_POST["duration"]
	);

	$dir = "./";  //make sure to put it bellow what the server can reach.
	file_put_contents("settings",serialize($settings));
	
}

/*
 * Get the Settings
 */
function get_settings(){
    return unserialize(file_get_contents("./settings"));
}

?>


<!DOCTYPE html>

<html>
<head>
	<title>The Social Box</title>
	
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
	
	<link href="./ostrich-sans-fontfacekit/stylesheet.css" type="text/css" rel="stylesheet"/>
	
	
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
			font-family: OstrichSansRoundedMedium, Arial, Verdana;
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
			font-family: OstrichSansMedium, Arial, Verdana;
			font-size: 280%;
			letter-spacing: 1pt;
			margin: 0 auto;
		}
		form{
			width: 100%;
			padding: 0;
			margin: 0;
		}
		input, select{
			font-size: 220%;
			width: 90%;
			height: 42px;
			background:#fffde9;
			color: #403f38;
			padding: 10px 5% 5px;
			margin: 10px 0;
			border: none;
			font-family: OstrichSansRoundedMedium, Arial, Verdana;
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
			font-size: 12pt;
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
	<div id="container">
		<img id="logo" src="images/logo.png" width=44 height=44/>
		<h1>SOCIAL MEDIA BOX</h1>
		<?php if(isset($_SESSION['loged']) && $_SESSION['loged']) : ?>
		<?php $savedSettings = get_settings();?>
		<form id="form" action="index.php" method="post">
			<input type="text" name="hashtag" onfocus="//this.value = '';" value="<?php echo ($savedSettings['hashtag']) ? $savedSettings['hashtag'] : 'hashtag' ?>">
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