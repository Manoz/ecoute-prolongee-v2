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

/**
 * Yes/No button for event meta box
 * @todo move this part in /inc/agenda-meta.php
 */
add_action( 'admin_init', 'ep_event_checkbox' );
function ep_event_checkbox() {

    $event_metabox = array(
        'id'        => 'event_checkbox',
        'title'     => 'Détails',
        'desc'      => '',
        'pages'     => array( 'ep-agenda' ),
        'context'   => 'normal',
        'priority'  => 'high',
        'fields'    => array(
            array(
                'label'     => 'Achat des places',
                'id'        => 'event_tickets',
                'type'      => 'text',
                'desc'      => 'URL pour l\'achat des places.',
            ),
            array(
                'label'     => 'Sold Out ?',
                'id'        => 'event_soldout',
                'type'      => 'on-off',
                'desc'      => 'Si l\'event est Sold Out ou non.',
                'std'       => 'off'
            )
        )
    );
    if ( function_exists( 'ot_register_meta_box' ) )
        ot_register_meta_box( $event_metabox );

}