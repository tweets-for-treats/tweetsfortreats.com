<?php
//Start the Session if it hasn't been started already
if(!isset($_SESSION)) session_start();

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

/*********************  ANTI HACKERS ********************/
function agentSmith($rawArray, $order){
    
    //Check for Login
    if($order === 'login'){
        //Check For Legal Caracters and Length
        $loginRegular = "/^[A-Za-z0-9 \£\$\@\-]{2,15}$/";
        foreach($rawArray as $key => $value){
            //If it macth then populate the cleaned Array with the Raw Array Values
            if (preg_match($loginRegular, $value)) {
                $cleaned[$key] = $value;
            //If it doesn't place neo instead of the value
            }else{
                $cleaned[$key] = 'neo';
                return $cleaned;
            }
        }
    }
    
    //If you Passed The Regular expression test, Check against MSQL Injections
    //Check if magic quotes is on ( if on it will add extra slash infront of a slash). Now off on most servers
    $magicQuotes = get_magic_quotes_gpc();
    foreach($cleaned as $key => $value){
        //If get magic is on , clean the extra slash
        if ($magicQuotes) $cleaned[$key] = stripslashes($value);
        //Clean against injections
        //$cleaned[$key] = mysql_real_escape_string($value);
    }
    
    return $cleaned;
}

/*********************** DEBUG ********************************/
function p($thingToPrint){
 echo sprintf("<pre>%s</pre>", print_r($thingToPrint, TRUE));
}