<?php

define('HANDLETOFOLLOW', "@reasonto");

/**********************
 *
 *
 *  Arduino Replies
 *
 *
 **********************/

 /*
  * Hashtag
  */
 
 function hashtag(){
            return "#reasonsto";        
 }
/*
* Speakers
*/

function speakers(){
                    $r = array(
                                        "@Mr_Bingo",
                                        "@ebrunborg",
                                        "@bantjes",
                                        "@labfoo",
                                        "@joshuadavis",
                                        "@evalottchen",
                                        "@bitchwhocodes",
                                        "@Jasmine_T",
                                        "@SebLester",
                                        "@mrpillustration",
                                        "@laurajaybee",
                                        "@C4RL05",
                                        "@jimtillustrator",
                                        "@WilfridWood",
                                        "@femkesvs",
                                        "@sagmeisterwalsh",
                                        "@BaldCondensed",
                                        "@KesselsKramer",
                                        "@bennewmanillo",
                                        "@JamFactory",
                                        "@jessicahische",
                                        "@quasimondo",
                                        "@AwayFoundation",
                                        "@andspo",
                                        "@thebeebs",
                                        "@Gegeniale",
                                        "@NellyBenHayoun",
                                        "@thatHollywood"
                    );
                    $m = $r[array_rand($r)];
                    return $m;
}
  

/*
 * random greetings for first time
 */
function greetings(){
                    $r = array(
                               "Thanks!",
                               "Hey!",
                               "Hey you,",
                               "Thx!",
                               "Hello,",
                               "Hi,"        
                    );
                    $m = $r[array_rand($r)];
                    return $m;
}


/*
 * random follow us response
 */
function follow_us(){
                    $r = array(
                                        "Follow ".HANDLETOFOLLOW." and you can have more #treats",
                                        "Follow ".HANDLETOFOLLOW." to get more",
                                        "Follow ".HANDLETOFOLLOW." and you can have some more",
                                        "Just follow ".HANDLETOFOLLOW." and you can have more #treats",
                                        "Just follow ".HANDLETOFOLLOW." to get more",
                                        "Just follow ".HANDLETOFOLLOW." and you can have some more"
                    );
                    $m = $r[array_rand($r)];
                    return $m;
}

/*
 * random greetings for second reply to users that already follow us
 */
function greetings_second_time_followers(){
                    $r = array(
                               "Hi again!",
                               "Hey you!",
                               "You again!",
                               "I recognise you!",
                               "You're back!",
                               "Hello again!",
                               "I've been expecting you.",
                               "We've been expecting you.",
                               "Back again?",
                               "We've been expecting you.",
                               "I've been expecting you."
                    );
                    $m = $r[array_rand($r)];
                    return $m;
}



/*
 * random greeting for last reply
 */
function end_off(){
                    $r = array(
                                        "That's it!",
                                        "Game over!",
                                        "No more!",
                                        "That's it.",
                                        "Game over.",
                                        "No more."
                    );
                    $m = $r[array_rand($r)];
                    return $m;
}

/*
 * Max Number of replies
 */
function max_replies_arduino(){
    return  4; //savePeople() and updatePeopleNbrTweets() use this!
}


/*
 * First time reply (instructions)
 */
function arduino_first_replies(){
    $g = greetings();
    $thisHashtag = hashtag();
    $prize = " Reply to us, it could be a free ticket for next year's ".$thisHashtag;
    $speakers = speakers();
    $replies = array(
                    $g." Did you get a gold treat? Don't eat it!".$prize,
                    $g." Got a gold treat? Don't eat it!".$prize,
                    $g." Got a gold treat?".$prize,
                    $g." Did you get a gold treat?".$prize,
                    $g." Got a shiny gold treat?".$prize,
                    $g." Got some treat bling?".$prize
                    );
    return $replies;
}


/**
 * BUILDING REPLIES
 */

/*
 * Second time instructions for none Followers
 */
function arduino_second_replies_not_following(){
                    $follow_us = follow_us();
                    $replies = array(
                                    "But we've only just met!".$follow_us,
                                    "You keep tweetin' we'll keep treatin'".$follow_us,
                                    "Hey you're keen! ".$follow_us,
                                    "You're keen! ".$follow_us,
                                    "Sweet :) ".$follow_us,
                                    "Those #treats are good, aren't they? ".$follow_us,
                                    "You couldn't resist ;) ".$follow_us,
                                    "Trick or #Treat? No tricks here, just #treats ".$follow_us,
                                    "Hey I recognise you! You're the #treat lover. ".$follow_us
                            );
                    return $replies;
}


/*
 * Second time instructions for Followers
 */
function arduino_second_replies_following(){
    //$helloAgain = greetings_second_time_followers();
    $helloAgain = greetings();
    
    $speakers = speakers();
    $thisHashtag = hashtag();
    
    $replies = array(
                    $helloAgain." Make sure you leave some for ".$speakers." ".$thisHashtag
                    );
    return $replies;
}


/*
 * All other replies
 */
function arduino_replies(){
                    $endOff = end_off();
                    $thisHashtag = hashtag();
                    $replies = array(
                        3 => array(
                            "Still feeling lucky punk? ".$thisHashtag,
                            "It's not real gold, calm down ".$thisHashtag,
                            "Those tickets are tempting, isn't it? ".$thisHashtag,
                            "Remember Charlie Bucket got the golden one in the end ".$thisHashtag,
                            "Did you know one of the golden treat is Scaramanga's fourth nipple? ".$thisHashtag,
                            "Maybe it's time to stop, I think people are looking at you strange ".$thisHashtag,
                            "Always beleive in Gold! ".$thisHashtag
                        ),
                        4 => array(
                            $endOff." You've reached your daily limit. Come back tomorrow for more free #treats ".$thisHashtag,
                            $endOff." No more #treats for you. Come back tomorrow for more free #treats ".$thisHashtag,
                            $endOff." You've reached your daily limit. Come back tomorrow if you want more ".$thisHashtag,
                            $endOff." You've reached your daily limit. We have to stop you here, come back tomorrow for more ".$thisHashtag,
                            $endOff." Leave some for the others! You've reached your daily limit. Come back tomorrow ".$thisHashtag,
                            $endOff." C'mon leave some for the others! You've reached your daily limit. Come back tomorrow ".$thisHashtag,
                            $endOff." C'mon leave some for the others! You've reached your daily limit ".$thisHashtag
                        )
                    );
                    return $replies;
}



/*
 * Follow us reminder
 */
function notFollowingReminder(){
    return "Remember to start following ".HANDLETOFOLLOW." if you want more #treats today";
}




/***********************************
 *
 *     Twitter Website replies
 *
 ***********************************/
function website_replies(){
    $g = greetings();
    $helloAgain = greetings_second_time_followers();
    $replies = array(
        1 => array(
            $g." Thanks for tweeting. Those guys have been waiting for ever to get a treat.",
            $g." Thanks for tweeting, have another go!",
            $g." Nice one! Those guys have been waiting for ever to get a treat ;)",
            $g." Those guys have been waiting for ever to get a treat ;)",
            $g." Those guys have been waiting for ever to get a treat.",
            $g." Did you know those guys are supposed to be on a diet?",
            $g." Don't feed those guys!",
            $g." Don't feed those guys - they're not ducks!"
        ),
        2 => array(
            $helloAgain." They're supposed to be on calorie controlled diet.",
            $helloAgain." They're supposed to be on diet.",
            $helloAgain." They're supposed to be on diet you know.",
            $helloAgain." They're on a calorie controlled diet.",
            $helloAgain." They're on a diet you know.",
            $helloAgain." They are supposed to be on calorie controlled diet.",
            $helloAgain." They are on calorie controlled diet.",
            $helloAgain." They are on a diet!",
            $helloAgain." He's supposed to be on calorie controlled diet.",
            $helloAgain." He's supposed to be on diet.",
            $helloAgain." He's supposed to be on diet you know.",
            $helloAgain." He's on a calorie controlled diet.",
            $helloAgain." He's on a diet you know.",
            $helloAgain." He is supposed to be on calorie controlled diet.",
            $helloAgain." He is on calorie controlled diet.",
            $helloAgain." He is on a diet!",          
            $helloAgain." There's only so many funny replies we can come up with",
            $helloAgain." There are only so many funny replies we can come up with",
            $helloAgain." I hope you're not at work!",
            $helloAgain." Aren't you supposed to be doing something more constructive with your time?",
            $helloAgain." Are you not supposed to be doing something more constructive with your time?",
            $helloAgain." Don't you think he's had enough treats?",
            $helloAgain." Don't you think he's had enough treats already?",
            $helloAgain." Don't you think he's already had enough treats?",
            $helloAgain." Don't you think they've had enough treats?",
            $helloAgain." Don't you think they've enough treats already?",
            $helloAgain." Don't you think they've already had enough treats?",
            $helloAgain." You know this is just a video, this isn't real",
            $helloAgain." You know this is just a video?",
            $helloAgain." You know this is just a video - right?"
        )
    );
    return $replies;
}


?>