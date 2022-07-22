$(function(){
    $("#alert-message").fadeTo(5000, 500).slideUp(500, function(){
        $('#alert-message').slideUp(500);
    });

    $('.cartbox_active').click(function(e){
        e.preventDefault();
        $('.minicart__active').toggleClass('is-visible');
    });
    $('.micart__close').click(function(e){
        e.preventDefault();
        $('.minicart__active').toggleClass('is-visible');
    });

    $('.setting_active').click(function(e){
        e.preventDefault();
        $('.searchbar__content').toggleClass('is-visible');
    });
});



