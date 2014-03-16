<?php
/**
 * Our custom post types
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

/* =======================================================
 *                 P O D C A S T S
 * ======================================================= */

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
        'edit_item'          => 'Éditer le podcast',
        'view_item'          => 'Voir le podcast',
        'all_items'          => 'Tout les podcasts',
        'search_items'       => 'Rechercher un podcast',
        'parent_item_colon'  => 'Podcast parent :',
        'not_found'          => 'Pas de podcast trouvé',
        'not_found_in_trash' => 'Pas de podcast dans la corbeille. Fallait pas la vider pédé',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'podcasts' ),
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
    register_post_type( 'podcasts', $args );
}

register_taxonomy(
    'podcast-cat',
    'podcasts',
    array(
        'hierarchical'      => true,
        'label'             => 'Catégories',
        'query_var'         => true,
        'rewrite'           => true,
        'show_in_nav_menus' => false
    )
);

/**
 * Add new column in "Podcast" pages
 * @since 1.0.0
*/

add_filter( 'manage_edit-podcasts_columns', 'podcasts_columns' );
function podcasts_columns( $columns ) {
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'title'         => 'Titre',
        'author'        => 'Auteur',
        'thumbnail'     => 'Thumbnails',
        'podcast-cat'   => 'Catégories',
        'date'          => 'Date',
    );
    return $columns;
}

add_action( 'manage_podcasts_posts_custom_column', 'manage_podcasts_columns', 10, 2 );
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
                echo '<strong><em style="color: #E93838;">Pas de catégorie :(</em></strong>';
            }
            break;
        case 'thumbnail':
            echo the_post_thumbnail( array( 60,60 ) );
                break;
    }
}

/* =======================================================
 *                 P L A Y L I S T S
 * ======================================================= */

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
        'edit_item'          => 'Éditer la playlist',
        'view_item'          => 'Voir la playlist',
        'all_items'          => 'Toutes les playlists',
        'search_items'       => 'Rechercher une playlist',
        'parent_item_colon'  => 'Parent Playlist :',
        'not_found'          => 'Pas de playlist trouvée',
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
        'rewrite'            => array( 'slug' => 'playlists' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => THEME_URI . '/framework/admin/images/icon-playlists.png',
        'supports'           => array(
            'title',
            'thumbnail',
            'playlist_metabox'
        )
    );
    register_post_type( 'playlists', $args );
}

register_taxonomy(
    'playlist-cat',
    'playlists',
    array(
        'hierarchical'      => true,
        'label'             => 'Catégories',
        'query_var'         => true,
        'rewrite'           => true,
        'show_in_nav_menus' => false
    )
);

/**
 * Add new column in "Playlists" pages
 * @since 1.0.0
*/
add_filter( 'manage_edit-playlists_columns', 'playlists_columns' );
function playlists_columns( $columns ) {
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'title'         => 'Titre',
        'author'        => 'Auteur',
        'thumbnail'     => 'Thumbnails',
        'playlist-cat'  => 'Catégories',
        'genre'         => 'Genre',
        'date'          => 'Date',
    );
    return $columns;
}

add_action( 'manage_playlists_posts_custom_column', 'manage_playlists_columns', 10, 2 );
function manage_playlists_columns( $name ) {
    global $wpdb, $wp_query, $post;
    switch ( $name ) {
        case 'playlist-cat':
            $terms = get_the_terms( $post->ID, 'playlist-cat' );
            if ( !empty( $terms ) ) {
                foreach ( $terms as $term ){
                    $post_terms[] = esc_html( sanitize_term_field('name', $term->name, $term->term_id, '', 'edit' ) );
                }
                echo implode( ', ', $post_terms );
            } else {
                echo '<em>Pas de catégorie</em>';
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
                echo '<strong><em style="color: #E93838;">T\'as oublié le genre :(</em></strong>';
            }
                break;
    }
}
