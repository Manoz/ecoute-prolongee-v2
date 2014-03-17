//Version 1.0.0

//(function($) { alert ('prout'); })(jQuery);

(function(window,undefined){

    // Prepare our Variables
    var
        History = window.History,
        $ = window.jQuery,
        document = window.document;

    // Check to see if History.js is enabled for our Browser
    if ( !History.enabled ) return false;

    // Wait for Document
    $(function () {
        // Again, prepare our variables
        var
            rootUrl         = ajax_data['rootUrl'],
            ThemeDir        = ajax_data['ThemeDir'],
            contentSelector = '.ep-content',
            $content        = $(contentSelector),
            contentNode     = $content.get(0),
            $body           = $(document.body),
            scrollOptions   = {
                duration: 800,
                easing: 'swing'
            };

        if ($content.length === 0) $content = $body;

        // Internal links helper
        $.expr[':'].internal = function (obj, index, meta, stack) {
            var
                $this = $(obj),
                url   = $this.attr('href') || '',
                isInternalLink;

            // Check the link
            isInternalLink = url.substring(0,rootUrl.length) === rootUrl || url.indexOf(':') === -1;

            // Ignore or Keep
            return isInternalLink;
        };

        var documentHtml = function(html){
            var result = String(html).replace(/<\!DOCTYPE[^>]*>/i, '')
                                     .replace(/<(html|head|body|title|script)([\s\>])/gi,'<div id="document-$1"$2')
                                     .replace(/<\/(html|head|body|title|script)\>/gi,'</div>');
            // Return
            return result;
        };

        $.fn.ajaxify = function () {

            var $this = $(this);

            // Let's ajaxify our content
            $this.find('a:internal:not(.no-ajaxy,[href^="#"],[href*="wp-login"],[href*="wp-admin"])').live('click', function(event){
                var
                    $this  = $(this),
                    url    = $this.attr('href'),
                    title  = $this.attr('title') || null;

                // Continue as normal for cmd clicks etc
                if (event.which == 2 || event.metaKey) return true;

                // Ajaxify this link
                History.pushState(null, title, url);
                event.preventDefault();
                return false;
            });

            return $this;
        };

        // Let's ajaxify our Internal links
        $body.ajaxify();

        // Hook into State Changes
        $(window).bind('statechange',function(){
            var
                State       = History.getState(),
                url         = State.url,
                relativeUrl = url.replace(ThemeDir, '');

            // Set Loading
            $body.addClass('loading');

            // Start fade out
            $content.animate({opacity:0},6000);

            $content
                .html( '<div class="ep-load"><img src="' + ThemeDir + 'images/ajax-loader.gif" /></div>' )
                .css('text-align', 'center');

            // Ajax Request the Traditional Page
            $.ajax( {
                url: url,
                    success: function(data, textStatus, jqXHR){
                        // Prepare again and again
                        var
                            $data           = $(documentHtml(data)),
                            $dataBody       = $data.find('#document-body:first ' + contentSelector),
                            bodyClasses     = $data.find('#document-body:first').attr('class'),
                            contentHtml, $scripts;

                        var $menu_list = $data.find('.ep-nav-wrap');

                        //Add classes to body
                        jQuery('body').attr('class', bodyClasses);

                        // Fetch the scripts
                        $scripts = $dataBody.find('#document-script');
                        if ( $scripts.length ) $scripts.detach();

                        // Fetch the content
                        contentHtml = $dataBody.html()||$data.html();

                        if ( !contentHtml ) {
                            document.location.href = url;
                            return false;
                        }

                        // Update the content
                        $content.stop(true,true);
                        $content.html(contentHtml)
                                .ajaxify()
                                .css('text-align', '')
                                .animate({opacity: 1, visibility: "visible"});

                        // Load some custom Script
                        epcustom.categories();

                        $('.ep-nav-wrap').html($menu_list.html());

                        //Adding no-ajaxy class to a tags present under ids provided

                        $(ajax_data['ids']).each(function(){
                            jQuery(this).addClass('no-ajaxy');
                        });

                        // Update the site title
                        document.title = $data.find('#document-title:first').text();
                        try {
                            document.getElementsByTagName('title')[0].innerHTML = document.title.replace('<', '&lt;').replace('>', '&gt;').replace(' & ', ' &amp; ');
                        }
                        catch ( Exception ) { }

                        // Add the scripts
                        $scripts.each(function(){
                            var $script = $(this),
                                scriptText = $script.html(),
                                scriptNode = document.createElement('script');
                            try {
                                // doesn't work on ie...
                                scriptNode.appendChild(document.createTextNode(scriptText));
                                contentNode.appendChild(scriptNode);
                            } catch(e) {
                                // IE has funky script nodes
                                scriptNode.text = scriptText;
                                contentNode.appendChild(scriptNode);
                            }
                            if ($(this).attr('src') != null) {
                                scriptNode.setAttribute('src', ($(this).attr('src')));
                            }
                        });

                        $body.removeClass('loading');

                        //scriptNode = document.createElement('script');
                        //contentNode.appendChild(scriptNode);
                        //scriptNode.setAttribute('src', rootUrl + 'wp-content/plugins/contact-form-7/includes/js/scripts.js');


                        // Inform Google Analytics of the change
                        if ( typeof window.pageTracker !== 'undefined' ) window.pageTracker._trackPageview(relativeUrl);

                        // Inform ReInvigorate of a state change
                        if ( typeof window.reinvigorate !== 'undefined' && typeof window.reinvigorate.ajax_track !== 'undefined' )
                            reinvigorate.ajax_track(url);
                    }, // End success: function()

                    error: function (jqXHR, textStatus, errorThrown) {
                        document.location.href = url;
                        return false;
                    }
            }); // End ajax

        }); // End onStateChange

    }); // End onDomLoad

})(window); // End closure