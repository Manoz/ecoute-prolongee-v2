/**
 * Écoute Prolongée scripts
 * @since 1.0.0
 */

(function($) {
    epcustom = {
        /* --------------------------------------------------
          =Better count for categories widget
        ----------------------------------------------------- */
        categories: function () {
            $('.ep-sidebar li.cat-item').each(function(){
                var $contents = $(this).contents();
                if ($contents.length > 1)  {
                    $contents.eq(1).wrap('<div class="cat-num"><span class="inner-num"></span></div>');

                    $contents.eq(1).each(function() {
                    });
                }
            }).contents();

            $('.ep-sidebar li.cat-item .cat-num .inner-num').each(function () {
                $(this).html($(this).text().substring(2));
                $(this).html( $(this).text().replace(/\)/gi, "") );
            });

            if ($('.ep-sidebar li.cat-item').length) {
                $('.ep-sidebar li.cat-item .cat-num .inner-num').each( function() {
                    if ($(this).is(':empty')){
                        $(this).parent().hide();
                    }
                });
            }
        }
    }
})(jQuery);

jQuery(document).ready(function($) {
    epcustom.categories();
});