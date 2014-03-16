<?php
/**
 * The Template for displaying all single posts
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
get_header(); ?>

    <div class="ep-inner">
        <div class="ep-main ep-cf" role="main">

        <?php
            while ( have_posts() ) : the_post();

                get_template_part( 'templates/content', 'single' );

                if ( comments_open() || get_comments_number() ) {

                    comments_template('/templates/comments.php');

                }

            endwhile; ?>

        </div>

        <?php get_sidebar(); ?>

    </div>

<?php get_footer();