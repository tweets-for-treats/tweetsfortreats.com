<?php

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
            $header_settings = array(
              'http'=>array(
                'method'=>"POST",
                'header'=>  "Host: api.twitter.com\r\n".
                            "User-Agent: My Twitter App v1.0.23\r\n".
                            "Authorization: Basic $key_encoded \r\n".
                            "Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
              )
            );
            
            $context = stream_context_create($header_settings);
            // Open the file using the HTTP headers set above
            $file = file_get_contents('https://api.twitter.com/oauth2/token?grant_type=client_credentials', false, $context);
            //$file = file_get_contents('https://api.twitter.com/oauth2/token', false, $context);
            
            if($file){
                //Isolate the Bearer Token
                $jsonResponse = json_decode($file);
                $bearer_token = $jsonResponse->access_token;
            }
            
            if($print) echo "<token>".$bearer_token."</token>";
            else return $bearer_token;

}

/*****************************/
/*     Make API Request      */
/*****************************/
function apiRequest($query, $token){
        if($token){
            // Header Setting 
            $API_header_Settings = array(
              'http'=>array(
                'method'=>"GET",
                'header'=>  "Host: api.twitter.com\r\n".
                            "User-Agent: My Twitter App v1.0.23\r\n".
                            "Authorization: Bearer ".$token
              )
            );
            
            $API_context = stream_context_create($API_header_Settings);
            
            // Open the file using the HTTP headers.
            $API_file = file_get_contents($query, false, $API_context);
            
            if($API_file){
                $json_tweets_response = json_decode($API_file);
                return $json_tweets_response;
            }
        }else{
            return false;
        }
}
function searchTwitter($q, $result_type, $count, $since_id, $token){
        if($since_id == NULL) $since_id = 0;
        $query = "https://api.twitter.com/1.1/search/tweets.json?q=$q&result_type=$result_type&count=$count&since_id=$since_id";
        $response = apiRequest($query, $token);
        if($response){
            echo "<max_id>".$response->search_metadata->max_id."</max_id>";
            echo "<nbr_tweets>".count($response->statuses)."</nbr_tweets>";
           
            echo "<statuses>";
            foreach($response->statuses as $tweet){
                echo "<tweet>";
                echo "<id>".$tweet->id."</id>";
                echo "<message>".$tweet->text."</message>";
                echo "<username>".$tweet->user->screen_name."<username>";
                echo "</tweet>";
                }
            echo "</statuses>";
        }
       printl($response);
}


if(isset($_GET["socialbox"]) && !empty($_GET["socialbox"])){
    //API REQUEST
    if(isset($_GET["q"])){
        searchTwitter(urlencode($_GET["q"]), $_GET["result_type"], $_GET["count"], $_GET["since_id"], urlencode($_GET["token"]));
    }
    //GET TOKEN
    if(isset($_GET["gettoken"])){
        echo getToken();
    }
}

?>