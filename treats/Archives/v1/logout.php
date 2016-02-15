<?php

//Load Utilities Fuctions
include 'utilities.php';

if(checkMemberLogin()) {
    session_destroy();
    go_to_login();
    exit;
}else{
    go_to_login();
}