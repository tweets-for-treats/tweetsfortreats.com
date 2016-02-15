<?php

//Load Utilities Fuctions
include 'utilities.php';

if(checkMemberLogin()) {
    session_destroy();
    go_to_login();
}else{
    go_to_login();
}