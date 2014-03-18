<?php
/**
 * Custom post type - Playlists
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

add_action( 'init', 'ep_create_playlists_post_type', 0 );
function ep_create_playlists_post_type() {
    $labels = array(
        'name'               => 'Playlists',
        'singular_name'      => 'Playlist',
        'menu_name'          => 'Playlists',
        'name_admin_bar'     => 'Playlist',
        'add_new'            => 'Ajouter une playlist',
        'add_new_item'       => 'Ajouter une playlist',
        'new_item'           => 'Nouvelle playlist',
        'edit_item'          => '&Eacute;diter la playlist',
        'view_item'          => 'Voir la playlist',
        'all_items'          => 'Toutes les playlists',
        'search_items'       => 'Rechercher une playlist',
        'parent_item_colon'  => 'Parent Playlist :',
        'not_found'          => 'Pas de playlist trouv&eacute;e',
        'not_found_in_trash' => 'Pas de playlist dans la corbeille',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'ep-playlists' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-format-audio',
        //'menu_icon'          => THEME_URI . '/framework/admin/images/icon-playlists.png',
        'supports'           => array(
            'title',
            'thumbnail',
            'playlist_metabox'
        )
    );
    register_post_type( 'ep-playlists', $args );
}

register_taxonomy(
    'playlist-cat',
    'ep-playlists',
    array(
        'hierarchical'      => true,
        'label'             => 'Cat&eacute;gories',
        'query_var'         => true,
        'rewrite'           => true,
        'show_in_nav_menus' => false
    )
);

/**
 * Add new column in "Playlists" pages
 * @since 1.0.0
*/
add_filter( 'manage_edit-ep-playlists_columns', 'playlists_columns' );
function playlists_columns( $columns ) {
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'title'         => 'Titre',
        'author'        => 'Auteur',
        'thumbnail'     => 'Thumbnails',
        'playlist-cat'  => 'Cat&eacute;gories',
        'genre'         => 'Genre',
        'date'          => 'Date',
    );
    return $columns;
}

add_action( 'manage_ep-playlists_posts_custom_column', 'manage_playlists_columns', 10, 2 );
function manage_playlists_columns( $name ) {
    global $wpdb, $wp_query, $post;
    switch ( $name ) {
        case 'playlist-cat':
            $terms = get_the_terms( $post->ID, 'playlist-cat' );
            if ( !empty( $terms ) ) {
                foreach ( $terms as $term ){
                    $post_terms[] = esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, '', 'edit' ) );
                }
                echo implode( ', ', $post_terms );
            } else {
                echo '<strong><em style="color: #E93838;">Pas de cat&eacute;gorie :(</em></strong>';
            }
            break;
        case 'thumbnail':
            echo the_post_thumbnail( array( 60,60 ) );
                break;
        case 'genre':
            $gender = get_post_meta( get_the_ID(), 'playlist_genre',  true);
            if ( !empty( $gender ) ) {
                echo $gender;
            } else {
                echo '<strong><em style="color: #E93838;">T\'as oubli&eacute; le genre :(</em></strong>';
            }
                break;
    }
}
