<?php

require_once('utilities.php');

login_check();


function login_check(){
        
        $myPassword = "caca123";
        
        //If the user just arrived here directly and isn't logged in: Exit function and let them fill the form
        if(empty($_POST['password'])) {
            if(!isset($_SESSION['error'])) $errorMessage = " ";
        }
        
        //The User is NOT logged In but is trying to: Start Process
        else{
             
        //Ask Agent Smith to Check everything and kick Neo out if needed
        $rawArray = array('password' => $_POST['password']);
        $cleaned = agentSmith($rawArray, 'login');
       
        //If the user entered non-authorized characters, Redirect to the login page
        if(in_array('neo', $cleaned)){
            $_SESSION['loged'] = false;
            $_SESSION['error'] = 'Only the following characters are allowed: a to z, 0 to 9, £, $, @ and -';
            go_to_login();
            exit;
        }
        
        //OtherWise Let's continue
        else{
            if ($cleaned['password'] === $myPassword) {
                session_regenerate_id();
                //$_SESSION['password'] = $cleaned['password'];
                $_SESSION['loged'] = true;
                //setPortfolioCookie();
                go_to_home_page();
                exit;
            }else{
                $_SESSION['loged'] = false;
                $_SESSION['error'] = 'Wrong Password';
                go_to_login();
                exit;
            }
        }
    }
}