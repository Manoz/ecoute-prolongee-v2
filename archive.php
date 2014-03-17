<?php
/**
 * Template for Archives page
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
global $post;
$post_type = get_post_type( $post->ID );
get_header(); ?>

    <header class="ep-sub-header">
    <?php
    if ( have_posts() ) :

        if( $post_type == 'interviews' ) {

            echo '<h2>Interviews</h2>';

        } elseif( is_archive() ) { ?>

            <h2><?php _e('Publiés par', 'ecoute') ?> <?php the_author_meta('nickname'); ?></h2>

        <?php }

    endif; ?>

    </header>

    <div class="ep-inner">
        <div class="ep-main ep-cf" role="main">

            <?php
            if ( have_posts() ) :

                while (have_posts()) : the_post();

                    get_template_part('templates/content', 'archive', get_post_format());

                endwhile;

                ep_page_nav();

            else:

                get_template_part('404');

            endif; ?>

        </div>
    </div>

<?php get_footer();