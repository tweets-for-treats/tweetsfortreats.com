<?php
require_once('send-mail.php');
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="minimal-ui">
    <title>Tweets for Treats</title>
    <meta name="description" content="Tweets for Treats is a tweet activated vintage treats dispenser. Give somebody a free treat if they mention you in a tweet.">
    <meta name="keywords" content="Black Sun, tweets, Tweets for Treats, internet of things">
    <meta name="author" content="Black Sun">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui'>

    <link rel="icon" type="image/png" href="img/favicon.png">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/treats.css">
    <script src="js/modernizr-2.6.2.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@iwanttreats">
    <meta name="twitter:creator" content="@iwanttreats">
    <meta name="twitter:title" content="It's a Tweet activated treats dispenser">
    <meta name="twitter:description" content="Tweets for Treats is a treats dispenser that rewards people who tweet about your project. Setup a hashtag and twitter handle then sit back and let people start tweeting.">
    <meta name="twitter:image" content="http://tweetsfortreats.com/img/twitter_card.jpg">

</head>
<body class="constrained">
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-65458845-1', 'auto');
    ga('send', 'pageview');

</script>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- ========================================= -->

<header>
    <div class="header-bg"></div>
    <img src="img/tweets-for-treats-logo.svg" class="tft-logo" alt="Tweets for Treats Logo">
    <ul class="nav-top not-mobile">
        <li class="not-tablet"><a href="#about">About</a></li>
        <li class="not-tablet"><a href="#how-it-works">How it works</a></li>
        <li class="not-tablet"><a href="#where-it-is">Where it is</a></li>
        <li class="not-tablet"><a href="#contact">Contact</a></li>
        <li>
            <a href="https://twitter.com/iwanttreats" target="_blank" class="twitter-bird"></a>
        </li>
    </ul>
</header>
<div class="video-wrapper">
    <div class="video-container">
        <div id="player"></div>
        <div class="text-container">
            <div class="book-title">
                <span class="title-lg">I Hope</span>
                <span class="title-sm">- You Enjoyed The -</span>
                <span class="title-lg">Treats</span>
            </div>
            <div class="tweet">
                <img src="img/book-title-header.svg" class="book-title-header" alt="Tweets for Treats book title motif">
                <div class="full-tweet">
                    <span class="tweet-line">Test</span>
                    <span class="tweet-line">123</span>
                    <span class="tweet-line"></span>
                    <span class="tweet-line"></span>
                    <span class="tweet-line"></span>
                    <span class="tweet-line"></span>
                    <span class="tweet-line"></span>
                    <span class="tweet-line"></span>
                    <span class="tweet-line"></span>
                    <span class="tweet-line"></span>
                </div>
                <img src="img/book-title-line.svg" class="book-title-line" alt="">
            </div>
            <div class="book-authors">
                <span class="author">Twitter Handle</span>
            </div>
            <div class="thumbs">

            </div>
        </div>
    </div>
</div>

<div class="video-overlays">
    <div class="play-again-caption fade-right">
        <div>Play Again</div>
        <div class="play-again">
            <svg version="1.1" fill="#ffffff" class="play-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                <path d="M25.7,12.9c0,0.1,0,0.2,0,0.2c0,0,0,0.1,0,0.1c-0.1,0.2-0.2,0.3-0.3,0.4L22,17.1c-0.2,0.2-0.5,0.3-0.8,0.3
                c-0.3,0-0.6-0.1-0.8-0.3c-0.4-0.4-0.4-1.1,0-1.5l1.6-1.6h-5.4c-3.3,0-6,2.7-6,6c0,1.6,0.6,3.1,1.7,4.2c0.4,0.4,0.4,1.1,0,1.5
                C12.3,25.9,12,26,11.7,26s-0.6-0.1-0.8-0.3c-1.5-1.5-2.4-3.5-2.4-5.7c0-4.5,3.6-8.1,8.1-8.1h5.4l-1.6-1.6c-0.4-0.4-0.4-1.1,0-1.5
                c0.4-0.4,1.1-0.4,1.5,0l3.4,3.4c0.1,0.1,0.2,0.3,0.3,0.4c0,0,0,0.1,0,0.1C25.7,12.8,25.7,12.9,25.7,12.9z"/>
                <path d="M31.4,20c0,4.5-3.6,8.1-8.1,8.1h-5.4l1.6,1.6c0.4,0.4,0.4,1.1,0,1.5c-0.2,0.2-0.5,0.3-0.8,0.3
                c-0.3,0-0.5-0.1-0.8-0.3l-3.4-3.4c-0.1-0.1-0.2-0.3-0.3-0.4c0,0,0-0.1,0-0.1c0-0.1,0-0.1,0-0.2s0-0.2,0-0.2c0,0,0-0.1,0-0.1
                c0.1-0.2,0.2-0.3,0.3-0.4l3.4-3.4c0.4-0.4,1.1-0.4,1.5,0c0.4,0.4,0.4,1.1,0,1.5L17.9,26h5.4c3.3,0,6-2.7,6-6c0-1.6-0.6-3.1-1.7-4.2
                c-0.4-0.4-0.4-1.1,0-1.5c0.4-0.4,1.1-0.4,1.5,0C30.6,15.8,31.4,17.9,31.4,20z"/>
            </svg>

        </div>
    </div>
    <div class="text-overlay">
        <div class="not-mobile not-tablet">
            <div class="intro-caption">
                <img src="img/instructions-left.svg" class="instructions-left" alt="Tweets for Treats instructions">
                <h1>Handle and Hashtag get written here</h1>
                <h3>Then wait for the countdown</h3>
                <img src="img/instructions-right.svg" class="instructions-right" alt="Tweets for Treats instructions">
            </div>
        </div>
    </div>
    <div class="error-container">
        <div class="error-text">
            <h1>Twitter Overload</h1>
            <h3>Too many requests are being made to Twitter</h3>
            <h3>Please try again at another time</h3>
        </div>
        <div class="error-bg"></div>
    </div>
    <a href="#about" class="scroll off-screen not-mobile">
        <svg version="1.1" class="scroll-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
            <g>
                <path d="M28.4,20.1c-0.5-0.5-1.3-0.5-1.8,0l-5.3,5.3V11.6c0-0.7-0.6-1.3-1.3-1.3c-0.7,0-1.3,0.6-1.3,1.3v13.8
                    L13.4,20c-0.5-0.5-1.3-0.5-1.8,0c-0.5,0.5-0.5,1.3,0,1.8l7.3,7.3c0,0,0.1,0.1,0.1,0.1c0.2,0.3,0.6,0.5,1,0.5c0.4,0,0.8-0.2,1-0.5
                    c0,0,0,0,0,0l7.3-7.3C28.9,21.4,28.9,20.6,28.4,20.1z"/>
            </g>
        </svg>
    </a>
    <div class="thanks"><a href="">A special thanks to...</a></div>
    <div class="row friends">
        <div class="white-top"></div>
        <img src="img/icon-close.svg" alt="close" class="icon-close" alt="close">
        <div class="col-sm-6">
            <div class="friend-block right">
                <div class="thumb-container">
                    <div class="friend-thumb pop" style="background: url(img/thumb-ollie.png) no-repeat center;"></div>
                </div>
                <h2 class="anim">VIDEO & PHOTOGRAPHY</h2>
                <h3 class="anim">Ollie Elmes</h3>
                <h4 class="anim">Maneouvre</h4>
                <hr class="inverted anim draw">
                <p class="anim">Thanks to Ollie at Maneouvre for his video expertise on the day of the shoot.</p>
                <p class="anim">Calm and collected even when things don't quite go to plan.</p>
                <a href="http://www.manoeuvrecreations.com/" target="_blank" class="btn-outline-inverted anim">Website</a>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="friend-block left">
                <div class="thumb-container">
                    <div class="friend-thumb pop" style="background: url(img/thumb-zephyr.png) no-repeat center;"></div>
                </div>
                <h2 class="anim">PROPS & COFFEE</h2>
                <h3 class="anim">Zephyr</h3>
                <h4 class="anim">Pelicano Coffee</h4>
                <hr class="inverted anim draw">
                <p class="anim">Thanks to Zephyr at Pelicano coffee for generously providing the stools featured in the shoot.</p>
                <p class="anim">...and the best coffee and cakes in Brighton.</p>
                <a href="https://www.facebook.com/Pelicanohouse" target="_blank" class="btn-outline-inverted anim">Website</a>
            </div>
        </div>
    </div>
</div>
<section id="about">
    <a name="about"></a>
    <div class="row">
        <div class="col-md-5 col-sm-6 col-xs-12">
            <div class="text-block right">

                <h2 class="anim">ABOUT</h2>
                <h3 class="anim">It's a Tweet activated treats dispenser</h3>
                <hr class="draw anim">
                <p class="anim">Tweets for Treats is a vintage treats dispenser that rewards people who tweet about a particular thing.</p>
                <p class="anim">What that thing is, well that’s up to you.</p>
                <p class="anim">Just place it somewhere and setup a hashtag and twitter handle to look for and then sit back and let people start tweeting.</p>
                <a href="#contact" class="btn-outline anim">Hire it now</a>

            </div>
        </div>
        <div class="col-md-7 col-sm-6 col-xs-12">
            <img src="img/tweets-for-treats.jpg" alt="Tweets for Treats vintage dispenser" class="sq-lg img-right">
        </div>
    </div>
</section>

<section id="how-it-works">
    <a name="how-it-works"></a>
    <div class="row inverted">
        <div class="col-sm-6 col-xs-12">
            <img src="img/tweets-for-treats-logo-etched.jpg" alt="Tweets for Treats etched into the glass container" class="sq-lg centered">
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="text-block left">

                <h2 class="anim">HOW IT WORKS</h2>
                <h3 class="anim">Easy to setup and even easier to use</h3>
                <hr class="inverted draw anim">
                <p class="anim">If you hire the Tweets for Treats dispenser you can use our online configuration tool to set it up to work with any Twitter handle and hashtag.</p>
                <p class="anim">If you want some treats then just send a tweet including the current handle and hashtag that are displayed on the front label.</p>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="col-sm-6">
                <div class="how-to-label">
                    <h3>Send a Tweet</h3>
                    <hr>
                    <p>Send a tweet containing the right hashtag and Twitter handle.</p>
                    <div class="arrow-down"></div>
                </div>
                <div class="how-to-image">
                    <img src="img/how-to-tweet-from-phone.jpg" alt="Tweet @IWantTreats" class="img-stretch image-top">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="how-to-image">
                    <img src="img/how-to-countdown-clock.jpg" alt="Tweets for Treats countdown clock" class="img-stretch image-bottom">
                </div>
                <div class="how-to-label bottom">
                    <h3>The Countdown</h3>
                    <hr>
                    <p>Wait for the countdown clock to reach zero before it checks Twitter.</p>
                    <div class="arrow-up"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-sm-6">
                <div class="how-to-label">
                    <h3>Activation Lamp</h3>
                    <hr>
                    <p>Once your tweet is found the overhead activation lamp will light up.</p>
                    <div class="arrow-down"></div>
                </div>
                <div class="how-to-image">
                    <img src="img/how-to-machine.jpg" alt="Tweets for Treats activation lamp" class="img-stretch image-top">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="how-to-image">
                    <img src="img/how-to-treats-in-hand.jpg" alt="Tweets for Treats reward" class="img-stretch image-bottom">
                </div>
                <div class="how-to-label bottom">
                    <h3>Insert your Hand</h3>
                    <hr>
                    <p>An infra-red sensor will detect your hand and automatically turn the release mechanism.</p>
                    <div class="arrow-up"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="contact">
    <a name="contact"></a>
    <div class="row inverted">
        <div class="col-sm-6">
            <div class="text-block left">

                <h2 class="anim">CONTACT</h2>
                <h3 class="anim">Hire it for your venue</h3>
                <hr class="inverted draw anim">
                <p class="anim">It's available for hire for conferences, weddings, parties or any other event where you want to encourage people to tweet.</p>
                <p class="anim">Contact us to get a quote, we're available for hire throughout the UK.</p>

            </div>
        </div>
        <div class="col-sm-6">
            <div class="contact-form">
                <form class="rent" method="post" id="contactForm">
                    <input type="text" name="name" id="name" placeholder="Your Name">
                    <input type="email" name="email" id="email" placeholder="Your Email">
                    <input type="text" name="location" id="location" placeholder="Your Location">
                    <textarea name="comments" id="comments" placeholder="Your Message"></textarea>
                    <span class="response">This is where the message goes</span>
                    <a href="" class="btn-outline-inverted" id="submit-btn">Submit</a>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="where-it-is">
    <a name="where-it-is"></a>
    <div class="row">
        <div class="col-sm-6">
            <div id="map-canvas">

            </div>
        </div>
        <div class="col-sm-6">
            <div class="text-block left">

                <h2 class="anim">WHERE IT IS</h2>
                <h3 class="anim">Go and see <br>it in action at</h3>
                <hr class="draw anim">
                <h3 class="date anim"><a href="https://www.facebook.com/TheCoffeeCounter/" target="_blank">The Coffee Counter</a></h3>
                <p class="address anim">
                    15 Vine Street<br>
                    Brighton<br>
                    BN1 4AG
                </p>

            </div>
        </div>
    </div>
</section>

<section id="awards">
    <a name="awards"></a>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="award-logo">
                <div class="award">
                    <img src="img/awards-copper-tubing.svg" alt="Award" class="front">
                    <img src="img/awards-grand-prix.svg" alt="Award" class="back">
                </div>
                <img src="img/award-shadow.png" alt="" class="award-shadow">
            </div>
        </div>
        <div class="col-md-4 col-sm-6 not-mobile">
            <div class="award-logo">
                <div class="award">
                    <img src="img/awards-jardiniere.svg" alt="Award" class="front">
                    <img src="img/awards-grand-prix.svg" alt="Award" class="back">
                </div>
                <img src="img/award-shadow.png" alt="" class="award-shadow">
            </div>
        </div>
        <div class="col-md-4 not-tablet not-mobile">
            <div class="award-logo">
                <div class="award">
                    <img src="img/awards-social-peanut.svg" alt="Award" class="front">
                    <img src="img/awards-grand-prix.svg" alt="Award" class="back">
                </div>
                <img src="img/award-shadow.png" alt="" class="award-shadow">
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="copyright">
        © Tweets for Treats - a <a href="http://www.blacksuncreative.com">Black Sun</a> Creation
    </div>
    <div class="made not-mobile">
        Made in Brighton
    </div>
</footer>

<div class="loading-cover zoomed">

</div>

<!-- ========================================= -->
<script src="js/jquery.1.11.1.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.loadie.min.js"></script>
<script src="js/popcorn.complete.min.js"></script>
<script src="js/jquery.inview.min.js"></script>
<script src="js/jquery.transit.js"></script>
<script src="js/retina-1.1.0.min.js"></script>
<script src="js/treats.js"></script>


</body>
</html>
