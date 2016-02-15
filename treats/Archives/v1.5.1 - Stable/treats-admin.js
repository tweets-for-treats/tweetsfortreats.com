$(document).ready(function() {
console.log('ready');
    $('.select select').change(function () {
        console.log('changed')
        var val = $(this).children('option:selected').html();
        $(this).siblings('.value').html(val);
    });

});
