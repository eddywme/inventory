(function ($) {
    $(document).ready(function(){

        $(function () {
            $(window).scroll(function () {

                // distance user needs to scroll before .top-line start fadeIn
                if ($(this).scrollTop() > 100) {
                    $('.top-line').fadeOut(250);
                } else {
                    $('.top-line').fadeIn(250);
                }
            });
        });

    });
}(jQuery));