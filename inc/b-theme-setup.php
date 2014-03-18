<?php
/**
 * Theme setup
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?');

/*
 * Custom Excerpt length
 * Custom Excerpt tag
 */
function ep_custom_excerpt_length( $length ) {
    return 50; // Excerpt length
}
add_filter( 'excerpt_length', 'ep_custom_excerpt_length', 999 );

// Inside the excerpt, replace the default [...] by ...
function ep_excerpt_more( $more ) {
    return ' ...';
}
add_filter('excerpt_more', 'ep_excerpt_more');

// Content width
if (!isset($content_width)) {$content_width = 960;}