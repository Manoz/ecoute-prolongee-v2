<?php
/**
 * Our theme functions and definitions
 *
 * @package Écoute Prolongée
 * @since   1.0.0
*/

/*
 * Define some constants
*/
define( 'THEME_URI',     get_template_directory_uri() );
define( 'THEME_DIR',     get_template_directory() );
define( 'THEME_JS',      THEME_URI .    '/js' );
define( 'THEME_INC',     THEME_URI .    '/inc' );
define( 'THEME_CSS',     THEME_URI .    '/css' );
define( 'FRAMEWORK_DIR', THEME_DIR.     '/framework/' );
define( 'FRAMEWORK_URI', THEME_URI.     '/framework/' );
define( 'CUSTOM_META',   FRAMEWORK_DIR. '/custom-meta/' );
define( 'CUSTOM_POST',   FRAMEWORK_DIR. '/custom-post/' );

/**
 * Load our base theme config files
 * @since 1.0.0
*/
require_once locate_template( '/inc/a-init.php' );        // Lang, nav and some theme support
require_once locate_template( '/inc/b-theme-setup.php' ); // Theme config (excerpt, content width,...)
require_once locate_template( '/inc/c-scripts.php' );     // Scripts and stylesheets
require_once locate_template( '/inc/d-tweaks.php' );      // Tweaks and utils
require_once locate_template( '/inc/e-widgets.php' );     // Sidebars and widgets
require_once locate_template( '/inc/f-comments.php' );    // Custom comments template
require_once locate_template( '/inc/g-clean.php' );       // Clean stuff for wp_head(), search, dashboard, ...
require_once locate_template( '/inc/h-posts-nav.php' );   // Display nav to next/prev pages
require_once locate_template( '/inc/i-navigation.php' );  // Custom walker for better wp_nav_menu
require_once locate_template( '/inc/j-ot-admin.php' );    // Admin framework


    /**
     * Load our custom meta and custom post types files
     * @since 1.0.0
    */

    // Playlists
    require_once locate_template( '/framework/custom-post/playlists.php' );
    require_once locate_template( '/framework/custom-meta/playlists-meta.php' );

    // Podcasts
    require_once locate_template( '/framework/custom-post/podcasts.php' );
    require_once locate_template( '/framework/custom-meta/podcasts-meta.php' );

    // Agenda
    require_once locate_template( '/framework/custom-post/agenda.php' );
    require_once locate_template( '/framework/custom-meta/agenda-meta.php' );

    // Interviews
    require_once locate_template( '/framework/custom-post/interviews.php' );



//require_once( get_template_directory_uri() . '/framework/custom-post/slider.php');
//require_once( get_template_directory_uri() . '/framework/custom-meta/slider-meta.php');
