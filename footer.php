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
</div> <!-- end .ep-container -->

<div id="fap">
    <a href="https://soundcloud.com/ecouteprolongee/sets/roulez-jeunesse-festival"></a>
</div>

<?php wp_footer();

require_once locate_template( '/inc/k-audio-player.php' );

    echo '
<script  type="text/javascript">
    (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

    ga(\'create\', \''.$g_id.'\', \'ecoute-prolongee.com\');
    ga(\'send\', \'pageview\');
</script>
    ';
 ?>

</body>
</html>