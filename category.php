<?php
/**
 * Template for category page
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
get_header(); ?>

    <header class="ep-sub-header">
        <h2>
        <?php
            if (is_category( 'interviews' )) { echo 'Interviews'; }
            elseif (is_category( 'concours' )) { echo 'Concours'; }
            elseif (is_category( 'playlists' )) { echo 'Playlists'; }
            elseif (is_category( 'podcasts' )) { echo 'Podcasts'; }
        ?>
        </h2>
    </header>

    <div class="ep-inner">
        <div class="ep-main ep-cf" role="main">

            <?php
            if ( have_posts() ) :

                while (have_posts()) : the_post();

                    get_template_part('templates/content', 'archive', get_post_format());

                endwhile;

                //ep_page_nav(); // Prev/next buttons

            else:

                get_template_part('404');

            endif;
get_footer();