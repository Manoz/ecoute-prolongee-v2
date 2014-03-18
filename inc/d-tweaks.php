<?php
/**
 * Tweaks and utils
 * You can add your tweaks and utils functions here.
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?');

/**
 * Better wp_title
 * @since 1.0.0
 */
function ep_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    $title .= get_bloginfo( 'name' );

    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'ecoute' ), max( $paged, $page ) );

    return $title;
}
add_filter( 'wp_title', 'ep_wp_title', 10, 2 );

/**
 * Function ep_is_element_empty()
 * @since 1.0.0
 */
function ep_is_element_empty($element) {
    $element = trim($element);
    return empty($element) ? false : true;
}

/**
 * Navigation for next/prev posts
 * @since 1.0.0
 */
if ( ! function_exists( 'ep_page_nav' ) ) :

    function ep_page_nav() {

        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        } ?>

        <nav class="post-nav ep-cf">
            <?php next_posts_link(__('Previous', 'ecoute')); ?>
            <?php previous_posts_link(__('Next', 'ecoute')); ?>
        </nav>

    <?php }

endif;
