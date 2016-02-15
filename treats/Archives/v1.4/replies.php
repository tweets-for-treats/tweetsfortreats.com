<?php

/**********************
 *
 *
 *  Arduino Replies
 *
 *
 **********************/

 
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
                                        "Follow us on Twitter and you can have more #treats",
                                        "Follow us on Twitter to get more",
                                        "Follow us and you can have some more",
                                        "Just follow us on Twitter and you can have more #treats",
                                        "Just follow us on Twitter to get more",
                                        "Just follow us and you can have some more",
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
                               "You're back!"
                               
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
                                        "No more.",
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
    $replies = array(
                    $g." Once you see the big light activated on the #treats dispenser just put your hand in the hole to grab your #treats",
                    $g." Once you see the big light activated on the #treats dispenser just put your hand in the hole to get your #treats",
                    $g." When the big light is on, put your hand in the hole and grab yourself some #treats",
                    $g." We're preparing your #treats. When the big light is on, put your hand in the hole and grab yourself some"
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
                                    "Quid pro quo my friend... ".$follow_us,
                                    "Hey you're keen! ".$follow_us,
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
    $helloAgain = greetings_second_time_followers();
    $replies = array(
                    $helloAgain." Quid pro quo my friend...",
                    $helloAgain." You're keen!",
                    $helloAgain." Sweet :)",
                    $helloAgain." Those #treats are good, aren't they?",
                    $helloAgain." You couldn't resist ;)",
                    $helloAgain." You're the treat lover"
                    );
    return $replies;
}


/*
 * All other replies
 */
function arduino_replies(){
                    $endOff = end_off();
                    $replies = array(
                        3 => array(
                            "I hope your gym membership hasn't expired because it looks like you'll need it tomorrow",
                            "Did you skip breakfast today?",
                            "Do you know these aren't your five-a-day?",
                            "If you don't ask, you don't get. Is that your moto?",
                            "I think people are looking at you strange, maybe it's time to stop",
                            "Hey, this doesn't count as a proper meal you know"
                        ),
                        4 => array(
                            $endOff." You've reached your daily limit. Come back tomorrow for more free #treats",
                            $endOff." No more #treats for you. Come back tomorrow for more free #treats",
                            $endOff." You've reached your daily limit. Come back tomorrow if you want more",
                            $endOff." You've reached your daily limit. We have to stop you here, come back tomorrow for more",
                            $endOff." Leave some for the others! You've reached your daily limit. Come back tomorrow."
                        )
                    );
                    return $replies;
}



/*
 * Follow us reminder
 */
function notFollowingReply(){
    return "Remember to start following us if you want more #treats today";
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
            $g." Looks like you've just published a book in our video. Have another go!",
            $g." What's that on the book? Thanks for tweeting, have another go!",
            $g." Nice one! Those guys have been waiting for ever to get a treat ;) Have another go"
        ),
        2 => array(
            $helloAgain." You're soon going to release a whole book serie",
            $helloAgain." There's only so many funny replies we can come up with",
            $helloAgain." I hope you're not at work!",
            $helloAgain." You know this is just a video, this isn't real",
            $helloAgain." Best book title ever :)",
        )
    );
    return $replies;
}


?>