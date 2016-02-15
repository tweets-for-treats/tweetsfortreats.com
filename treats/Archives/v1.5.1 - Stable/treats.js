//-------------------------------
// Google Map
//-------------------------------
//
// Used to load a Google Map instance
// and also set it's appearance

if(document.getElementById('map-canvas')){

    var mapStyle = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];

    function initialize() {
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
            center: new google.maps.LatLng(50.8253386,-0.1529292),
            zoom: 16,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            panControl: true,
            draggable: false,
            styles: mapStyle
        }

        var map = new google.maps.Map(mapCanvas, mapOptions);
        var latlang = new google.maps.LatLng(50.8253386,-0.1529292);
        var markerIcon = new google.maps.MarkerImage("img/map-marker.svg", null, null, null, new google.maps.Size(48,75));

        var marker = new google.maps.Marker({
            position: latlang,
            map: map,
            icon: markerIcon
        });

        marker.setMap(map);

    }

    google.maps.event.addDomListener(window, 'load', initialize);

}


// Youtube Video iFrame API
// -------------------------------------------------

var tweetCheck = false;
var tweetFound = false;
var showBook = false;
var videoEnd = false;
var vs;
var tag = document.createElement('script');


tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 1. This function creates an <iframe> (and YouTube player)
// -------------------------------------------------
// This happens after the API code downloads.

var player;

function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        height: '1080',
        width: '1920',
        videoId: 'BD3P9mGEkaY',
        playerVars: {
            'autoplay': 1,
            'controls': 0,
            'rel': 0,
            'enablejsapi': 1,
            'showinfo': 0,
            'modestbranding': 1
        },
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

// 2. The API will call this function when the video player is ready.
// -------------------------------------------------
function onPlayerReady(event) {
    $('body').loadie(1);
    setTimeout(revealSite, 800);
    event.target.playVideo();
    playbackMonitor();
}

// 3. The API calls this function when the player's state changes.
// -------------------------------------------------
function onPlayerStateChange(event) {

    if (event.data == 0) {
        clearInterval(vs);
    }

}

function playVideo() {
    player.playVideo();
}

function stopVideo() {
    player.stopVideo();
    clearInterval(vs);
}

function pauseVideo() {
    player.pauseVideo();
}

function jumpToCue(c) {
    tweetCheck = false;
    tweetFound = false;
    showBook = false;
    videoEnd = false;

    player.seekTo(c);
}

// Function used to check state of Browser Tab
// -------------------------------------------------
// An inactive browser tab reduces the rate at which setInterval
// fires which can cause the video not to loop and run through to
// the end - so this function pauses the video.


var vis = (function(){
    var stateKey, eventKey, keys = {
        hidden: "visibilitychange",
        webkitHidden: "webkitvisibilitychange",
        mozHidden: "mozvisibilitychange",
        msHidden: "msvisibilitychange"
    };
    for (stateKey in keys) {
        if (stateKey in document) {
            eventKey = keys[stateKey];
            break;
        }
    }
    return function(c) {
        if (c) document.addEventListener(eventKey, c);
        return !document[stateKey];
    }
})();

vis(function(){
    if( vis() ) {
        playVideo();
    } else {
        pauseVideo();
    }
});


$(document).ready(function(){

    // Global Vars
    // -----------------------------------

    var awardWidth;
    var awardHeight;
    var vid;
    var hashtag     = createHashtag();
    var btx         = 470;
    var bty         = 125;
    var ttx         = 484;
    var tty         = 125;
    var bax         = 500;
    var bay         = 530 - $('.book-authors').height();


    // Local Storage
    // -----------------------------------
    // Check for availability of localStorage then use
    // it to store the 'since_id' when requesting tweets
    // from the Twitter API to avoid counting the last tweets

    function setSinceID(id){
        if (Modernizr.localstorage) {
            localStorage.setItem('since_id', id);
        } else {
            // no native support for HTML5 storage :(
            // could try a third-party solution if we are really fussed about older browsers
        }
    }

    // Generate random Hashtag
    // -----------------------------------
    // Creates a reasonably unique hashtag for each viewer of the site
    // to avoid the video responding to tweets from other people using
    // the same hashtag.

    function createHashtag() {
        var possible = "abcdefghjklmnpqrstuvwxyz123456789";
        var str = "";
        /*
        for( var i=0; i < 3; i++ ) {
            str += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        */
        var str = Math.floor(Math.random() * 999);
        return str;
    }

    $('.intro-caption').find('h1').html('@IWantTreats #' +hashtag);

    // Twitter API
    // -----------------------------------
    // Check for any matching Tweets

    var totalTweets;
    var handles;
    var tempHandles;
    var matchedTweet;

    function getTweets(){

        totalTweets     = 0;
        handles         = new Array();
        tempHandles     = new Array();
        matchedTweet    = "";

        $.post("treats/web.php", {
                results:5,
                hashtag: hashtag,
                since_id: localStorage.getItem('since_id')
            },
            function(data, status){

                if(status == "success") {

                    if(data.statuses.length >= 1) {
                        console.log(data.statuses[0].message);

                        matchedTweet = data.statuses[0].message;
                        totalTweets = data.nbr_tweets;
                        handles[0] = data.statuses[0].username;

                        writeTweet();
                    }
                    setSinceID(data.since_id);

                }else{
                    console.log("fail");
                }

            }, "json");
    }

    // Write Tweet to the screen
    // -----------------------------------
    // If there is a matched tweet then write it to be
    // the title of the book and the handle to be the author

    var charWidth       = 15;
    var spaceWidth      = 8;
    var iWidth          = 5;
    var tweetWidth      = 250;
    var fontSize        = 20;
    var testTweet       = "";

    function writeTweet(){

        var charLimit       = 18;
        var cword           = "";
        var cline           = "";
        var lineCount       = 1;

        // BOOK TITLE
        $('.tweet-line').empty();

        matchedTweet += " ";

        // Check if the matched tweet is just the handle and hashtag - if so then show the default book title
        var finalHash = '#'+hashtag;
        testTweet = matchedTweet;
        testTweet = testTweet.toUpperCase();
        testTweet = testTweet.replace( "@IWANTTREATS", "" );
        testTweet = testTweet.replace( finalHash, "" );
        var tweetWords = testTweet.split(" ");


        if( (jQuery.trim( testTweet )).length <= 2 ) {
            $('.tweet').css({ opacity:0 });
            $('.book-title').css({ opacity:1 });
        } else {

            for (w = 0; w < tweetWords.length; w++) {

                cword = tweetWords[w];
                if (cword.length > charLimit) {
                    cword = "";
                }

                if (cline.length + cword.length < charLimit) {
                    cline += cword + " ";
                    if (w == tweetWords.length - 1) {
                        var letterSize = calcScale(cline);
                        $('.tweet-line:nth-child(' + lineCount + ')').css({
                            fontSize: letterSize + 'px',
                            'line-height': '0.9em'
                        });
                        $('.tweet-line:nth-child(' + lineCount + ')').html(cline);
                        cline = "";
                        cline += cword + " ";
                        lineCount++;
                    }
                } else {

                    var letterSize = calcScale(cline);
                    $('.tweet-line:nth-child(' + lineCount + ')').css({
                        fontSize: letterSize + 'px',
                        'line-height': '0.9em'
                    });
                    $('.tweet-line:nth-child(' + lineCount + ')').html(cline);
                    cline = "";
                    cline += cword + " ";
                    lineCount++;
                }

            }
        }

        // BOOK AUTHORS
        $('.book-authors').empty();

        var newHandle = $('<span class="author">'+handles[0]+'</span>');
        $('.book-authors').append(newHandle);

        //Empty handles array for next time
        while(handles.length > 0) {
            handles.pop();
        }

        //Position authors correctly on the book
        resize();

    }

    function calcScale( str ) {
        var spaces      = (str.match(/ /g) || []).length;
        var is          = (str.match(/i/g) || []).length;
        var others      = str.length - ( spaces + is );
        var strWidth    = (spaces * spaceWidth) + (is * iWidth) + (others * charWidth);

        var scale       = tweetWidth / strWidth;
        var size        = fontSize * scale;

        // Set position from top of book
        if( testTweet.length < 20 ) {
            tty = 145;
        } else if( testTweet.length < 40  ) {
            tty = 135;
        }

        // Cap the size of text
        if( size > 45 ) {
            size = 45;
        }

        return size;
    }


    // Scroll into view
    //-------------------------------
    // Used to check when page elements scroll
    // into view of the display area and then
    // animate them with fade and movement.

    //Only do this if not a touch device as animations don't start until scrolling is finished and it looks weird
    //if(!Modernizr.touch){

        $('section').find('.text-block').one('inview', function(event, visible){
            setTimeout(showText, 400, $(this));
        });

    //}

    // Layout and Resize handling
    // -----------------------------------
    // Make the video proportionately fit the browser window
    // so that we don't get any borders due to aspect ratio.

    // Add the resize function to the window resize event but put it on a short timer as to not call it too often
    var resizeTimer;
    $(window).resize(function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(resize(), 10);
    });

    // resize handler updates width, height and offset of player after resize/init
    var resize = function() {

        var width = $(window).width(),
            pWidth, // player width, to be defined
            height = $(window).height(),
            pHeight, // player height, tbd
            $videoContainer = $('.video-container'),
            $videoPlayer = $('#player');

        // when screen aspect ratio differs from video, video must center and underlay one dimension
        if(height > 600 || width > 700){
            if (width / options.ratio < height) { // if new video height < window height (gap underneath)
                pWidth = Math.ceil(height * options.ratio); // get new player width
                $videoPlayer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0}); // player width is greater, offset left; reset top
                $videoContainer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0});
            } else { // new video width < window width (gap to right)
                pHeight = Math.ceil(width / options.ratio); // get new player height
                $videoPlayer.width(width).height(pHeight).css({left: 0, top: 0 }); // player height is greater, offset top; reset left
                $videoContainer.width(width).height(pHeight).css({left: 0, top: 0 });
            }

            var xpos        = $videoPlayer.width()/2;
            var vw          = $videoPlayer.width();
            var vh          = $videoPlayer.height();
            var vscale      = vw/1280;


            $('.book-title').css('transform', 'scale(' + vscale + ') rotate(-4.2deg)');
            $('.book-title').css('left', btx*vscale);
            $('.book-title').css('top', bty*vscale);

            $('.tweet').css('transform', 'scale(' + vscale + ') rotate(-4.2deg)');
            $('.tweet').css('left', ttx*vscale);
            $('.tweet').css('top', tty*vscale);

            $('.book-authors').css('transform', 'scale(' + vscale + ') rotate(-5.5deg)');
            $('.book-authors').css('left', bax*vscale);
            $('.book-authors').css('top', bay*vscale);
        }

        // Intelligent image stretching
        var ratio = 841/764;
        var h = $('.sq-lg').parent().parent().height();

        if(width <= 1165 && width >= 768) {
            $('.sq-lg').css({ height: h, width: Math.round(h*ratio)+'px' });
        } else {
            $('.sq-lg').css({ width: '100%', height: 'auto' });
        }
        var offsetx = ($('.centered').parent().width() - $('.centered').width())/2;
        $('.centered').css({ marginLeft: offsetx + 'px' });

        // Award logo spinning width and frequency
        if( width > 1165 ){
            awardWidth = '300px';
            awardHeight = '81px';
        } else {
            awardWidth = '260px';
            awardHeight = '71px';
        }
        if( width <= 700 ) {
            countTotal = 1;
        } else if( width < 1000 ) {
            countTotal = 2;
        } else {
            countTotal = 3;
        }

    }

    // Video controllers
    // -----------------------------------
    // Uses setInterval and getCurrentTime() to track playback
    // position of the YouTube video and jump to cue points
    // depening on it's current position.

    var defaults = {
        ratio: 16/9, // usually either 4/3 or 16/9 -- tweak as needed
        mute: true,
        repeat: true,
        width: $(window).width(),
        start: 0
    };
    var options = $.extend({}, defaults, options);
    var ct = 0;

    window.playbackMonitor = function() {

        // Clear any old setIntervals that might be running
        if(vs){ clearInterval( vs ); }

        vs = setInterval( function() {

            ct = Math.round( player.getCurrentTime() * 10 ) / 10;

            // TEST
            /*
            if( ct >= 3.5 && ct <= 4 ) {
                showBook = true;
                $('.text-container').transition({opacity: 1}, 0);
                $('.text-container').transition({scale: [1.2, 1.2]}, 10000);
                clearInterval( vs );
            }
            */

            // 19.5s : Check for matching tweets
            if( ct >= 21.5 && ct <= 22 && !tweetCheck) {
                tweetCheck = true;
                getTweets();
            }

            // 24.5s : Loop video if no matching tweets found
            if( ct >= 24.5 && ct <= 25 ) {
                if(totalTweets == 0){
                    tweetCheck = false;
                    jumpToCue( 0 );
                } else {
                    if(!tweetFound){
                        tweetFound = true;
                        $('.intro-caption').transition({ opacity:0 }, 600, 'out');
                    }
                }
            }

            // 53s : Show book close-up
            if( ct >= 52.5 && ct <= 53 && !showBook ) {
                showBook = true;
                $('.text-container').css({ opacity: 1 });
                $('.text-container').transition({ scale: [1.2, 1.2] }, 1000);
            }

            // 55s : End, show play again button
            if( ct >= 55 && !videoEnd ) {
                videoEnd = true;
                clearInterval( vs );
                $('.play-again-caption').removeClass('fade-right');
                hide($('.thanks'), 500);
            }

        }, 200  );
    }

    $('.play-again').click(function(){
        $('.text-container').stop().transition({ opacity: 0.01 }, 500, function(){
            $('.book-title').css({ opacity:0 });
            $('.tweet').css({ opacity:1 });
            $(this).transition({ scale: [1, 1] },0);
            $(this).css({ opacity:0.01 });
            tweetCheck = false;
        });
        $('.play-again-caption').addClass('fade-right');
        show($('.thanks'), 500);
        show($('.intro-caption'), 500);
        playbackMonitor();
        jumpToCue( 0 );
    });

    window.revealSite = function(){
        resize();
        if (Modernizr.touch) {
            hide($('#player'),0);
        }
        hide( $('.loading-cover') , 1500 );
        $('body').removeClass('constrained');
        setTimeout(showScroll, 1500);
    }

    function showScroll() {
        $('.scroll').removeClass('off-screen');
    }

    // Page Scroll Animating
    // -----------------------------------
    // Used to animate the internal links
    // to named anchors in the page

    $('a[href^="#"]').on('click',function (e) {
        e.preventDefault();

        var target = this.hash;
        var $target = $(target);

        $('html, body').stop().animate({ 'scrollTop': $target.offset().top - $('header').height() }, 900, function() {
            window.location.hash = target - $('header').height();
        });
    });

    $(window).on("scroll", function() {
        if($(window).scrollTop() > 50) {
            $('.header-bg').addClass('header-bg-active');
        } else {
            //remove the background property so it comes transparent again (defined in your css)
            $('.header-bg').removeClass('header-bg-active');
        }
    });

    // Contact Form
    // -----------------------------------
    // Post the contact form - pass the entered
    // details to send-mail.php

    $("#submit-btn").click(function(e) {

       e.preventDefault();

        var url = "send-mail.php";

        var n = $('#name').val();
        var e = $('#email').val();
        var c = $('textarea').val();
        var l = $('#location').val();



       if(n != '' && e != '' && c != '' && l != ''){

           if(validateEmail(e)){

                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#contactForm").serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        //clear form and show message
                        $('#name').val('');
                        $('#email').val('');
                        $('#location').val('');
                        $('textarea').val('');
                        $('span.response').removeClass('error');
                        $('span.response').html(data);
                        $('span.response').transition({opacity:1},500,'out');
                        setTimeout(function(){
                            $('span.response').transition({opacity:0},500,'out');
                        },3000);
                    }
                });

           }else{
               $('span.response').addClass('error');
               $('span.response').html('You must enter a valid email address');
               $('span.response').transition({opacity:1},500,'out');
           }

       }else{
           $('span.response').addClass('error');
           $('span.response').html('You must fill all the fields');
           $('span.response').transition({opacity:1},500,'out');
       }

        return false; // don't execute the standard form submit.
    });

    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
        if( !emailReg.test( $email ) ) {
            return false;
        } else {
            return true;
        }
    }

    // General Helpers
    // -----------------------------------
    // Helper functions

    function show( obj , speed ) {
        obj.css({ display: 'block' });
        obj.transition({ opacity:1 }, speed);
    }

    function hide( obj , speed ) {
        obj.transition({ opacity:0 }, speed, function() {
            obj.css({ display: 'none' });
        });
    }

    // Thanks to...
    // -----------------------------------
    // Setup initial state and then
    // show and hide the Thanks to our Friends panel

    $('.friends').css({ width:0 });
    hide( $('.icon-close'), 0 );
    hide( $('.friend-block'), 0 );

    $('.thanks').click(function( e ) {
        e.preventDefault();
        $('.friends').show();
        $('.friends').transition({ width: '100%' }, 400, 'easeOutExpo', function() {
            show( $('.icon-close'), 300 );
            show( $('.friend-block'), 300 );
            showText( $('.friend-block') );
        });
    });

    $('.icon-close').click(function( e ) {
        e.preventDefault();
        $('.friend-block').find('.anim').addClass('fade-top');
        $('.friend-block').find('.pop').addClass('pop-out');
        $('.friend-block').find('.draw').addClass('draw-left');
        setTimeout( function() {
            hide( $('.friend-block'), 0 );
            $('.friends').transition({ width: 0 }, 600, 'easeOutExpo', function() {
                $('.friends').hide();
                hide( $('.icon-close'), 0 );
            });
        }, 400);
    });

    // Animate Circles
    // -----------------------------------
    // Draws a circle shape and fades in the background.
    // Used on the scroll button and for the friend thumbs.

    var transform_styles = ['-webkit-transform', '-ms-transform', 'transform'];
    window.drawCircle = function() {
        var rotation = 180;
        var fill_rotation = rotation;
        var fix_rotation = rotation * 2;
        for(i in transform_styles) {
            $('.circle .fill, .circle .mask.full').css(transform_styles[i], 'rotate(' + fill_rotation + 'deg)');
            $('.circle .fill.fix').css(transform_styles[i], 'rotate(' + fix_rotation + 'deg)');
        }
    }

    // Twitter Bird
    // -----------------------------------
    // Animate the bird on hover

    $('.twitter-bird').hover(function(){
        $(this).toggleClass('twitter-bird-anim');
    });

    // Animate Text
    // -----------------------------------
    // Animates the text that appears in
    // each section - usually triggered by 'inview'

    if(!Modernizr.touch) {
        $('.anim').addClass('fade-top');
        $('.draw').addClass('draw-left');
        $('.pop').addClass('pop-out');
    }

    function showText( obj ) {
        var dLength = 100;
        obj.find('.anim').each(function( i ){
            var d = $(this);
            setTimeout(function(){ d.removeClass('fade-top'); d.removeClass('draw-left'); }, dLength*i);
        });
        obj.find('.pop').removeClass('pop-out');
    }

    // Logo click
    // -----------------------------------

    $('.tft-logo').click(function(e){
        e.preventDefault();
        $('html, body').stop().animate({
            'scrollTop': 0
        }, 700, 'swing');
    });

    // Awards
    // -----------------------------------
    // Spinning award logos

    var counter = 0;
    var countTotal = 3;
    var awardCounter = 0;
    var totalAwards = 4;
    var awardLogos = [];
    awardLogos[0] = 'img/awards-grand-prix.svg';
    awardLogos[1] = 'img/awards-copper-tubing.svg';
    awardLogos[2] = 'img/awards-jardiniere.svg';
    awardLogos[3] = 'img/awards-social-peanut.svg';

    function spinLogo( obj ) {
        $('.award').each(function( i ) {
            if( i == counter ){
                var logo = $(this);
                var front = logo.find('.front');
                var back = logo.find('.back');
                if( back.css('opacity') == 0 ) {
                    logo.data( 'nextLogo', back );
                    logo.data( 'prevLogo', front );
                    back.attr( 'src', awardLogos[awardCounter] );
                } else {
                    logo.data( 'nextLogo', front );
                    logo.data( 'prevLogo', back );
                    front.attr( 'src', awardLogos[awardCounter] );
                }
                logo.parent().find('.award-shadow').transition({ opacity:0.3, scaleX:0.5 }, 1000, 'easeInExpo');
                logo.transition({ rotateY: '90deg' }, 1000, 'easeInExpo', function() {
                    logo.css({ rotateY: '-90deg'} );
                    logo.data('nextLogo').css({ opacity: 1 });
                    logo.data('prevLogo').css({ opacity: 0 });
                    logo.transition({ rotateY: '0deg' }, 1000, 'easeOutExpo');
                    logo.parent().find('.award-shadow').transition({ opacity:1, scaleX:1 }, 1000, 'easeOutExpo');
                });
            }
        });
        counter ++;
        if(counter >= countTotal) { counter = 0; }
        awardCounter ++;
        if(awardCounter >= totalAwards) { awardCounter = 0; }
    }

    setInterval(spinLogo, 2000);

    // Initialise
    // -----------------------------------

    $('body').loadie(0.7);


});


