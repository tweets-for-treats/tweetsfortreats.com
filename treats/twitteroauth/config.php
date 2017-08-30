<?php

/**
 * @file
 * A single location to store configuration.
 */


/**
 *
 * Change details depending on Location (localhost vs online)
 *
 **/
$whitelist = array(
    '127.0.0.1',
    '::1'
);
//ONLINE
/*if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
    define('URL', 'http://www.tweetsfortreats.com');
    define('HOST', 'internal-db.s179275.gridserver.com');
}
//LOCALHOST
else{
    define('URL', 'http://localhost/tweetsfortreats.com');
    define('HOST', '127.0.0.1');
}*/
//TESTING ARDUINO: FORCE IT
define('URL', 'http://192.168.0.18/tweetsfortreats.com');
define('HOST', '127.0.0.1');


/*
 * Define CONSTANTS for Arduino
 *
 */
if(ARDUINO){
    define('CONSUMER_KEY', 'e2o8TLx1BUFZr1YXBwWwIm7bm');
    define('CONSUMER_SECRET', 'xDqxfyOM2ZST17QSdsrEbSPOT2dS43gc2Yl9d1x1uIFn256yS5');
    define('OAUTH_CALLBACK', URL.'/treats/twitteroauth/callback.php');
    define('OAUTH_ACCESS_TOKEN', '428577233-ACEqCgbkbuJOcHQ9nuIf1fa8LCNLk011Ca68yXqo');
    define('OAUTH_ACCESS_TOKEN_SECRET', '2WVOb9lzLfcAfu06d63d0JtEKIODOqaLRk8RFxp8xYTE8');
}
/*
 * Define CONSTANTS for Website
 *
 */
if(!ARDUINO){
    define('CONSUMER_KEY', 'gMG5rmUis1d93o9zuPJ2EQEtX');
    define('CONSUMER_SECRET', 'NB7nBd24VUKZDo97eARpcNnGRxOW8XrvVEFSGFCcJWuWuVsWFt');
    define('OAUTH_CALLBACK', URL.'/treats/twitteroauth/callback.php');
    define('OAUTH_ACCESS_TOKEN', '428577233-TVt20PKjbZU4RkDct7CVIZiJIwhPOKg3Mm4Qlf3i');
    define('OAUTH_ACCESS_TOKEN_SECRET', 'KGVeHuECfRv9BhPEFyzxqeGzSSCisy8SLaJgq4o1MTOv1');
}


?>
