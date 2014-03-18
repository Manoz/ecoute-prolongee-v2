<?php
/**
 * Custom post type - Agenda
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

add_action( 'init', 'ep_create_agenda_post_type', 0 );
function ep_create_agenda_post_type() {
    $labels = array(
        'name'               => 'Agenda',
        'singular_name'      => 'Agenda',
        'menu_name'          => 'Agenda',
        'name_admin_bar'     => 'Agenda',
        'add_new'            => 'Ajouter un event',
        'add_new_item'       => 'Ajouter un event',
        'new_item'           => 'Nouvel event',
        'edit_item'          => '&Eacute;diter l\'event',
        'view_item'          => 'Voir l\'event',
        'all_items'          => 'Tous les events',
        'search_items'       => 'Rechercher un event',
        'parent_item_colon'  => 'Agenda parent :',
        'not_found'          => 'Pas d\'event trouv&eacute;',
        'not_found_in_trash' => 'Pas d\'event dans la corbeille',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'ep-agenda' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-calendar',
        //'menu_icon'          => THEME_URI . '/framework/admin/images/icon-agenda.png',
        'supports'           => array(
            'title',
            'agenda_metabox'
        )
    );
    register_post_type( 'ep-agenda', $args );
}

register_taxonomy(
    'agenda-cat',
    'ep-agenda',
    array(
        'hierarchical'      => true,
        'label'             => 'Cat&eacute;gories',
        'query_var'         => true,
        'rewrite'           => true,
        'show_in_nav_menus' => false
    )
);

/**
 * Add new column in "Agenda" pages
 * @since 1.0.0
*/
add_filter( 'manage_edit-ep-agenda_columns', 'agenda_columns' );
function agenda_columns( $columns ) {
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'title'         => 'Titre',
        'author'        => 'Auteur',
        'ep-date'       => 'Date de l\'event',
        'ep-lieux'      => 'Lieux',
        'ep-prix'       => 'Prix'
    );
    return $columns;
}

add_action( 'manage_ep-agenda_posts_custom_column', 'manage_agenda_columns', 10, 2 );
function manage_agenda_columns( $name ) {
    global $wpdb, $wp_query, $post;
    switch ( $name ) {
        case 'agenda-cat':
            $terms = get_the_terms( $post->ID, 'agenda-cat' );
            if ( !empty( $terms ) ) {
                foreach ( $terms as $term ){
                    $post_terms[] = esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, '', 'edit' ) );
                }
                echo implode( ', ', $post_terms );
            } else {
                echo '<strong><em style="color: #E93838;">Pas de cat&eacute;gorie :(</em></strong>';
            }
            break;
        case 'ep-date':
            $jour = get_post_meta( get_the_ID(), 'ep_jour_value',  true);
            $mois = get_post_meta( get_the_ID(), 'ep_mois_value',  true);
            if ( !empty( $jour ) || !empty( $mois ) ) {
                echo $jour . ' ' . $mois;
            } else {
                echo '<strong><em style="color: #E93838;">T\'as oubli&eacute; quelque chose :(</em></strong>';
            }
                break;
        case 'ep-lieux':
            $lieux = get_post_meta( get_the_ID(), 'ep_lieux_value',  true);
            if ( !empty( $lieux ) ) {
                echo $lieux;
            } else {
                echo '<strong><em style="color: #E93838;">Pas de lieux ? :(</em></strong>';
            }
                break;
        case 'ep-prix':
            $prix = get_post_meta( get_the_ID(), 'ep_prix_value',  true);
            if ( !empty( $prix ) ) {
                echo $prix;
            } else {
                echo '<strong><em style="color: #E93838;">Pas de prix ? :(</em></strong>';
            }
                break;
    }
}
