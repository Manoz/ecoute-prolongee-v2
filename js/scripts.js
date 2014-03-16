/**
 * Écoute Prolongée scripts
 * @since 1.0.0
 */

/* --------------------------------------------------------------------
  =Better count for categories
-------------------------------------------------------------------- */

(function($) {
    $('.secondary li.cat-item').each(function(){
        var $contents = $(this).contents();
        if ($contents.length > 1)  {
            $contents.eq(1).wrap('<div class="cat-num"><span class="inner-num"></span></div>');

            $contents.eq(1).each(function() {
            });
        }
    }).contents();

    $('.secondary li.cat-item .cat-num .inner-num').each(function () {
        $(this).html($(this).text().substring(2));
        $(this).html( $(this).text().replace(/\)/gi, "") );
    });

    if ($('.secondary li.cat-item').length) {
        $('.secondary li.cat-item .cat-num .inner-num').each( function() {
            if ($(this).is(':empty')){
                $(this).parent().hide();
            }
        });
    }
})(jQuery);
