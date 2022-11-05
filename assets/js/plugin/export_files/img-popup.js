(function ($) {
    $('body').on('click','.img-popup a' ,function(e){
        e.preventDefault();
        var imgLink = $(this).children('img').attr('src');
        $('.mask').html('<div class="img-box"><img src="'+ imgLink +'"><a class="close">&times;</a>');
        $('.mask').attr('style','display: block !important;');
        $('body').on('click','.close', function(){
            $('.mask').attr('style','');
        });
    });
})(jQuery);
