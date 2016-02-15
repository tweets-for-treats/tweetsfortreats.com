<?php

    /* MAILGUN includes */

    require 'vendor/autoload.php';
    use Mailgun\Mailgun;

    $mg_comments = $_POST['comments'];
    $mg_name = $_POST['name'];
    $mg_email = $_POST['email'];
    $mg_location = $_POST['location'];

    /* Get submitted values */

    if ($mg_name && $mg_email && $mg_comments && $mg_location){
        sendMail($mg_name,$mg_email,$mg_location,$mg_comments);

        $result = 'Thanks. Your message has been sent.';
        $disable = true;

        echo $result;
    }

    /* MAILGUN send functions */

    function sendMail($mg_name,$mg_email,$mg_location,$mg_comments){

        $mg_comments = $mg_name ."\n\n". $mg_email ."\n\n". $mg_location ."\n\n". $mg_comments;

        # Instantiate the client.
        $mgClient = new Mailgun('key-ba5beab58409970b83b08a4e8a6a71f5');
        $domain = "tweetsfortreats.com";

        $mgClient->sendMessage($domain,
        array('from'    => $mg_email,
        'to'            => 'spencer@blacksuncreative.com,spencer@leftlobe.co.uk',
        'h:Reply-To'    => $mg_email,
        'subject'       => 'Tweets for Treats - Website Enquiry',
        'text'          => $mg_comments));

    }


?>