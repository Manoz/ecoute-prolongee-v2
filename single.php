<?php
/**
 * The Template for displaying all single posts
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
$post_type = get_post_type( $post->ID );
get_header();

if( $post_type == 'ep-podcasts' ) { ?>

    <header class="ep-sub-header">
        <h2><?php the_title(); ?></h2>
    </header>

<?php } ?>

    <div class="ep-inner">
        <div class="ep-main ep-cf" role="main">

        <?php

            while ( have_posts() ) : the_post();

                if( $post_type == 'ep-podcasts' ) {

                    get_template_part( 'templates/content', 'podcast' );

                } else {

                    get_template_part( 'templates/content', 'single' );
                }

                if ( comments_open() || get_comments_number() ) {

                    comments_template('/templates/comments.php');

                }

            endwhile; ?>

        </div>

        <?php if( $post_type == 'post' ) { get_sidebar(); } ?>

    </div>

<?php get_footer();