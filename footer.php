<?php
/**
 * 'Start Here' footer
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
?>
    </div> <!-- end .ep-content -->

    <footer class="ep-footer">
        <div class="ep-inner">
            <div class="copyright ep-cf">
                <div class="copyright-left">
                    <span>&copy; Copyright 2014 - Écoute Prolongée</span>
                    <span>Les morceaux que nous publions ne nous appartiennent pas et sont la propriété de leurs auteurs respectifs. Nous les diffusons uniquement dans un but promotionnel.</span>
                </div>
                <div class="copyright-right">
                    <span class="address">183 rue Duguesclin, 69003 - Lyon</span>
                    <span class="email"><a href="#">coucou@ecoute-prolongee.com</a></span>
                </div>
            </div>
        </div>
    </footer>
</div> <!-- end .ep-container -->

<?php wp_footer();

if( function_exists( 'get_option_tree') ) {
    $theme_options = get_option('option_tree');
    $id = get_option_tree('analytics_id',$theme_options);

    echo '
<script>
    (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

    ga(\'create\', \''.$id.'\', \'ecoute-prolongee.com\');
    ga(\'send\', \'pageview\');
</script>
    ';
} ?>

</body>
</html>