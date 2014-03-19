<?php
/**
 * Enqueue scripts and stylesheets
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?');

function ep_styles() {
    // Protocol (http or https) for webfonts
    $prot = is_ssl() ? 'https' : 'http';
    $opensans = 'Open+Sans:300,400,600';
    $ptsans   = 'PT+Sans:400,700,400italic,700italic';

    wp_register_style('normalize',    THEME_CSS . '/normalize.css', false, '1.0.0'  );
    wp_register_style('ep_main',      THEME_CSS . '/main.css', false, '1.0.0');
    wp_register_style('ep_fonts',     THEME_CSS . '/fonts.css', false, '1.0.0');
    wp_register_style('ep_player',    THEME_CSS . '/audio-player.css', false, '1.0.0');
    wp_register_style('ep_player-rs', THEME_CSS . '/audio-player-responsive.css', false, '1.0.0');
    wp_register_style('webfont',   "$prot://fonts.googleapis.com/css?family=$opensans|$ptsans" );

    wp_enqueue_style( 'normalize');
    wp_enqueue_style( 'ep_main' );
    wp_enqueue_style( 'ep_fonts' );
    wp_enqueue_style( 'ep_player' );
    wp_enqueue_style( 'ep_player-rs' );
    wp_enqueue_style( 'webfont' );

}
add_action( 'wp_enqueue_scripts', 'ep_styles' );

function ep_scripts() {

    if (is_single() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_register_script( 'ep-scripts',       THEME_JS . '/scripts.js', array( 'jquery' ), '1.0.0', true );
    wp_register_script( 'ep-ajaxify',       THEME_JS . '/ajaxify.js', array( 'jquery' ), '1.0.0', true );
    wp_register_script( 'ep-history',       THEME_JS . '/history.js', array( 'jquery' ), '1.0.0', true );
    wp_register_script( 'ep-amplify',       THEME_JS . '/amplify.min.js', array( 'jquery' ), '1.0.0', true );
    wp_register_script( 'ep-soundmanager',  THEME_JS . '/soundmanager.min.js', array( 'jquery' ), '1.0.0', true );
    wp_register_script( 'ep-audioplayer',   THEME_JS . '/audioplayer.min.js', array( 'jquery' ), '1.0.0', true );

    wp_enqueue_script( 'ep-scripts' );
    wp_enqueue_script( 'ep-history' );
    wp_enqueue_script( 'ep-ajaxify' );
    wp_enqueue_script( 'soundcloud', 'https://connect.soundcloud.com/sdk.js','jquery','','in_footer');
    wp_enqueue_script( 'ep-amplify' );
    wp_enqueue_script( 'ep-soundmanager' );
    wp_enqueue_script( 'ep-audioplayer' );

    $ajax_data = array(
        'rootUrl'   => site_url() . '/',
        'ThemeDir'  => get_template_directory_uri() . '/',
    );
    wp_localize_script('ep-ajaxify', 'ajax_data', $ajax_data);

    //wp_enqueue_script( 'ep-slider' );
}
add_action( 'wp_enqueue_scripts', 'ep_scripts' );
