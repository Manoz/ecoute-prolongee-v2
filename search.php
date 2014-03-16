<?php
/**
 * Template for Search results pages
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
get_header();

if ( have_posts() ) : ?>

    <header class="ep-archive-header">
        <h1 class="archive-title"><?php printf( __( 'Search Results for: %s', 'ecoute' ), get_search_query( '', false ) ); ?></h1>
    </header>

<?php
    while (have_posts()) : the_post();

        get_template_part('loop', get_post_format());

    endwhile;

    //ep_page_nav(); // Prev/next buttons

else:

    get_template_part('404');

endif;
get_sidebar();
get_footer();