<?php
/**
 * Enqueue scripts and stylesheets
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
function ep_styles() {
    // Protocol (http or https) for webfonts
    $prot = is_ssl() ? 'https' : 'http';
    $opensans = 'Open+Sans:300,400,600';
    $ptsans   = 'PT+Sans:400,700,400italic,700italic';

    wp_register_style('normalize', THEME_CSS . '/normalize.css', false, '1.0.0'  );
    wp_register_style('ep_main',   THEME_CSS . '/main.css', false, '1.0.0');
    wp_register_style('ep_fonts',  THEME_CSS . '/fonts.css', false, '1.0.0');
    wp_register_style('webfont',   "$prot://fonts.googleapis.com/css?family=$opensans|$ptsans" );

    wp_enqueue_style( 'normalize');
    wp_enqueue_style( 'ep_main' );
    wp_enqueue_style( 'ep_fonts' );
    wp_enqueue_style( 'webfont' );

}
add_action( 'wp_enqueue_scripts', 'ep_styles' );

function ep_scripts() {

    if (is_single() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_register_script( 'ep-scripts', THEME_JS . '/scripts.js', array( 'jquery' ), '1.0.0', true );
    //wp_register_script( 'ep-slider',  THEME_JS . '/flexslider.min.js', array( 'jquery' ), '2.2', true );

    wp_enqueue_script( 'ep-scripts' );
    //wp_enqueue_script( 'ep-slider' );
}
add_action( 'wp_enqueue_scripts', 'ep_scripts' );
