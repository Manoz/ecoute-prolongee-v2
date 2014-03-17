<?php
/**
 * The template for displaying Tag pages
 * Used to display archive-type pages for posts in a tag.
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
get_header();

if ( have_posts() ) : ?>

    <header class="ep-sub-header">
        <h2 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'ecoute' ), single_tag_title( '', false ) ); ?></h2>
    </header>

    <div class="ep-inner">
        <div class="ep-main-int ep-main ep-cf" role="main">

        <?php
            while (have_posts()) : the_post();

                get_template_part('loop', get_post_format());

            endwhile;

            ep_page_nav();

        ?>
        </div>
    </div>

<?php else:

    get_template_part('404');

endif;
get_footer();