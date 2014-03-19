<?php
/**
 * 'Start Here' footer
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?');
if ( function_exists( 'get_option_tree') ) { $theme_options = get_option( 'option_tree' ); }
$g_id       = get_option_tree( 'analytics_id',           $theme_options );
$copyright  = get_option_tree( 'footer_copyright',       $theme_options );
$under_copy = get_option_tree( 'footer_copyright_left',  $theme_options );

?>

    </div> <!-- end .ep-content -->

    <footer class="ep-footer">
        <div class="ep-inner">
            <div class="copyright ep-cf">
                <div class="copyright-left">
                    <span><?php echo $copyright; ?></span>
                    <span><?php echo $under_copy; ?></span>
                </div>
                <div class="copyright-right">
                    <span class="address">183 rue Duguesclin, 69003 - Lyon</span>
                    <span class="email"><a href="#">coucou@ecoute-prolongee.com</a></span>
                </div>
            </div>
        </div>
    </footer>
<div id="fap">
    <a href="https://soundcloud.com/ecouteprolongee/sets/tumblr"></a>
</div>
</div> <!-- end .ep-container -->

<?php wp_footer();

    echo '
<script>
    (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

    ga(\'create\', \''.$g_id.'\', \'ecoute-prolongee.com\');
    ga(\'send\', \'pageview\');
</script>
    ';
 ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
    soundManager.url = '<?php echo get_template_directory_uri();?>/inc/swf/';
    soundManager.flashVersion = 9;
    soundManager.useHTML5Audio = true;
    soundManager.debugMode = false;

    $('#fap').fullwidthAudioPlayer({
        twitterText: 'Tweeter',
        facebookText: 'Partager sur Facebook',
        opened: true,
        volume: true,
        autoLoad: true,
        playNextWhenFinished: true,
        socials: true
    });

});
</script>

</body>
</html>