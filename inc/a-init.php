<?php
/**
 * Our theme constants
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

add_action( 'after_setup_theme', 'ep_setup' );
function ep_setup() {
    load_theme_textdomain( 'ecoute', get_template_directory() . '/lang' );

    register_nav_menus(array(
        'primary_navigation' => __( 'Main nav', 'ecoute' ),
    ));

    // Add some theme support
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'nice-search' );

    // Add post formats
    add_theme_support( 'post-formats', array(
        'audio', 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
    ) );

}
