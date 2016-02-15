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
                    $g." Wait for the big light then stick your hand in the hole for your #treats",
                    $g." Wait for the big light then insert your hand in the hole for your #treats",
                    $g." When you see the big light switch on stick your hand in the hole for your #treats",
                    $g." When the big light turns on stick your hand in the hole for your #treats",
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
    $helloAgain = greetings_second_time_followers();
    $replies = array(
                    $helloAgain." Hey you're a dedicated follower of treats!",
                    $helloAgain." Fill yer boots!",
                    $helloAgain." Back for more?",
                    $helloAgain." You're keen!",
                    $helloAgain." Remember, treats should form part of a balanced diet",
                    $helloAgain." Go one, fill yer boots!",
                    $helloAgain." Sweet :)",
                    $helloAgain." Those #treats are good, aren't they?",
                    $helloAgain." You couldn't resist ;)",
                    $helloAgain." You couldn't resist!",
                    
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
                            "Maybe it's time to stop, I think people are looking at you strange",
                            "Hey, this doesn't count as a proper meal you know"
                        ),
                        4 => array(
                            $endOff." You've reached your daily limit. Come back tomorrow for more free #treats",
                            $endOff." No more #treats for you. Come back tomorrow for more free #treats",
                            $endOff." You've reached your daily limit. Come back tomorrow if you want more",
                            $endOff." You've reached your daily limit. We have to stop you here, come back tomorrow for more",
                            $endOff." Leave some for the others! You've reached your daily limit. Come back tomorrow.",
                            $endOff." C'mon leave some for the others! You've reached your daily limit. Come back tomorrow.",
                            $endOff." C'mon leave some for the others! You've reached your daily limit."
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
            $g." Thanks for tweeting.",
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