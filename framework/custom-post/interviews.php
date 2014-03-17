<?php
/**
 * Custom post type - Interviews
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

add_action( 'init', 'ep_create_interviews_post_type', 0 );
function ep_create_interviews_post_type() {
    $labels = array(
        'name'               => 'Interviews',
        'singular_name'      => 'Interview',
        'menu_name'          => 'Interviews',
        'name_admin_bar'     => 'Interviews',
        'add_new'            => 'Ajouter une interview',
        'add_new_item'       => 'Ajouter une interview',
        'new_item'           => 'Nouvelle interview',
        'edit_item'          => '&Eacute;diter l\'interview',
        'view_item'          => 'Voir l\'interview',
        'all_items'          => 'Toutes les interviews',
        'search_items'       => 'Rechercher une interview',
        'parent_item_colon'  => 'Interview parent :',
        'not_found'          => 'Pas d\'interview trouv&eacute;',
        'not_found_in_trash' => 'Pas d\'interview dans la corbeille',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'interviews' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => THEME_URI . '/framework/admin/images/icon-interviews.png',
        'supports'           => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            'comments',
            'revisions'
        )
    );
    register_post_type( 'interviews', $args );
}

register_taxonomy(
    'interview-cat',
    'interviews',
    array(
        'hierarchical'      => true,
        'label'             => 'Cat&eacute;gories',
        'query_var'         => true,
        'rewrite'           => true,
        'show_in_nav_menus' => false
    )
);

/**
 * Add new column in "Interview" pages
 * @since 1.0.0
*/
add_filter( 'manage_edit-interviews_columns', 'interview_columns' );
function interview_columns( $columns ) {
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'title'         => 'Titre',
        'author'        => 'Auteur',
        'interview-cat' => 'Catégorie',
        'date'          => 'Date',
        'thumbnail'     => 'Thumbnails'
    );
    return $columns;
}

add_action( 'manage_interviews_posts_custom_column', 'manage_interview_columns', 10, 2 );
function manage_interview_columns( $name ) {
    global $wpdb, $wp_query, $post;
    switch ( $name ) {
        case 'interview-cat':
            $terms = get_the_terms( $post->ID, 'interview-cat' );
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
    }
}
