$(document).ready(function(){

    var arrayOfImages = [

        'img/machine/still1.jpg',
        'img/machine/still2.jpg',
        'img/machine/still3.jpg',
        'img/machine/still4.jpg',
        'img/machine/still5.jpg',
        'img/machine/still6.jpg',
        'img/machine/still7.jpg',
        'img/machine/still8.jpg',
        'img/machine/still9.jpg',
        'img/machine/still10.jpg',
        'img/machine/still11.jpg',
        'img/machine/still12.jpg',
        'img/machine/still13.jpg',
        'img/machine/still14.jpg',
        'img/machine/still15.jpg',
        'img/machine/still16.jpg',
        'img/machine/still17.jpg',
        'img/machine/still18.jpg',
        'img/machine/still19.jpg',
        'img/machine/still20.jpg',
        'img/machine/still21.jpg',
        'img/machine/still22.jpg',
        'img/machine/still23.jpg',
        'img/machine/still24.jpg',
        'img/machine/still25.jpg',
        'img/machine/still26.jpg',
        'img/machine/still27.jpg',
        'img/machine/still28.jpg',
        'img/machine/still29.jpg',
        'img/machine/still30.jpg',
        'img/machine/still31.jpg',
        'img/machine/still32.jpg'

    ]

    var rotator     = $('#rotator');
    var minScale    = 0.45;
    var maxScale    = 1.4;
    var w           = 1000;
    var h           = 1780;

    rotator.rollerblade({
        imageArray:arrayOfImages,
        sensitivity: 1,
        drag: true,
        auto: false
    });

    $(window).resize(function(){
       resize();
    });

    function resize() {

        var ww      = $('.rotator-wrapper').width();
        var wh      = $('.rotator-wrapper').height();
        var xOffset = (ww - w)/2;
        //var yOffset = (wh - h)/2;

        console.log('ww: '+ww+ " w: "+w+ " xOffset: " +xOffset);

        $('#rotator').css({left: xOffset+'px'});
    }

    $('.zoom-in').click(function(){

        var s = rotator.css('scale');
        var newScale = s += 0.2;
        newScale = (s > maxScale) ? maxScale : s;

        $('#rotator').transition({ scale: newScale },200);
        $('.display-area').transition({ height: h*newScale }, 0);

    });

    $('.zoom-out').click(function(){

        var s = rotator.css('scale');
        var newScale = s -= 0.2;
        newScale = (s < minScale) ? minScale : s;

        $('#rotator').transition({ scale: newScale },200, function(){
            //console.log($(this).offset().top);
            //console.log($(this).parent().parent().scrollTop());
            if($(this).offset().top < 20) {
                $(this).parent().parent().animate({scrollTop: 0}, 300);
            }
            $('.display-area').transition({ height: Math.max(h*newScale+'px') }, 0);
        });

    });

    rotator.mousedown(function(){
       $('#drag-info').hide();
    });

    // -----------------------------------------------
    // Initialise
    // -----------------------------------------------

    resize();
    $('#rotator').transition({ scale: 0.45 },300);


});






