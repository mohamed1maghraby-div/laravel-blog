$(function(){
    $("#alert-message").fadeTo(5000, 500).slideUp(500, function(){
        $('#alert-message').slideUp(500);
    });

    $('.cartbox_active').click(function(){
        $('.minicart__active').toggleClass('is-visible');
    });
    $('.micart__close').click(function(){
        $('.minicart__active').toggleClass('is-visible');
    });

    $('.setting_active').click(function(){
        $('.searchbar__content').toggleClass('is-visible');
    });
});



