<?php
/**
 * Contains all the Theme Options functions.
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?');
/**
 * Hide the OptionTree documentation.
 * Comment the filter to show the documentation.
 * Uncomment to hide.
 */
add_filter( 'ot_show_pages', '__return_false' );


// Required: set 'ot_theme_mode' filter to true.
add_filter( 'ot_theme_mode', '__return_true' );

// Required: include OptionTree.
require_once locate_template('/option-tree/ot-loader.php');

// Theme Options
include_once( 'z-theme-options.php' );
