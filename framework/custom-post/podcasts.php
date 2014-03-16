<?php
/**
 * Custom post type - Podcasts
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

add_action( 'init', 'ep_create_podcasts_post_type', 0 );
function ep_create_podcasts_post_type() {
    $labels = array(
        'name'               => 'Podcasts',
        'singular_name'      => 'Podcast',
        'menu_name'          => 'Podcasts',
        'name_admin_bar'     => 'Podcast',
        'add_new'            => 'Ajouter un podcast',
        'add_new_item'       => 'Ajouter un podcast',
        'new_item'           => 'Nouveau podcast',
        'edit_item'          => '&Eacute;diter le podcast',
        'view_item'          => 'Voir le podcast',
        'all_items'          => 'Tout les podcasts',
        'search_items'       => 'Rechercher un podcast',
        'parent_item_colon'  => 'Podcast parent :',
        'not_found'          => 'Pas de podcast trouv&eacute;',
        'not_found_in_trash' => 'Pas de podcast dans la corbeille. Fallait pas la vider p&eacute;d&eacute;',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'ep-podcasts' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => THEME_URI . '/framework/admin/images/icon-podcasts.png',
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
            'podcasts_metabox'
        )
    );
    register_post_type( 'ep-podcasts', $args );
}

register_taxonomy(
    'podcast-cat',
    'ep-podcasts',
    array(
        'hierarchical'      => true,
        'label'             => 'Cat&eacute;gories',
        'query_var'         => true,
        'rewrite'           => true,
        'show_in_nav_menus' => false
    )
);

/**
 * Add new column in "Podcast" pages
 * @since 1.0.0
*/

add_filter( 'manage_edit-ep-podcasts_columns', 'podcasts_columns' );
function podcasts_columns( $columns ) {
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'title'         => 'Titre',
        'author'        => 'Auteur',
        'thumbnail'     => 'Thumbnails',
        'podcast-cat'   => 'Cat&eacute;gories',
        'date'          => 'Date',
    );
    return $columns;
}

add_action( 'manage_ep-podcasts_posts_custom_column', 'manage_podcasts_columns', 10, 2 );
function manage_podcasts_columns( $name ) {
    global $wpdb, $wp_query, $post;
    switch ( $name ) {
        case 'podcast-cat':
            $terms = get_the_terms( $post->ID, 'podcast-cat' );
            if ( !empty( $terms ) ) {
                foreach ( $terms as $term ){
                    $post_terms[] = esc_html( sanitize_term_field('name', $term->name, $term->term_id, '', 'edit' ) );
                }
                echo implode( ', ', $post_terms );
            } else {
                echo '<strong><em style="color: #E93838;">Pas de cat&eacute;gorie :(</em></strong>';
            }
            break;
        case 'thumbnail':
            echo the_post_thumbnail( array( 60,60 ) );
                break;
    }
}
