<?php
/**
 * Add new taxonomy, NOT hierarchical (like tags)
 * taxonomy = slider
 * object type = slide (Name of the object type for the taxonomy object)
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

function ep_custom_slider() {
    $labels = array(
        'name'                  => 'Slider',
        'singular_name'         => 'Slider',
        'add_new'               => 'Ajouter une slide',
        'add_new_item'          => 'Ajouter une slide',
        'edit_item'             => 'Editer une slide',
        'new_item'              => 'Nouvelle slide',
        'view_item'             => 'Voir la slide',
        'search_items'          => 'Rechercher une slide',
        'not_found'             => 'Aucun slider trouvé',
        'not_found_in_trash'    => 'Aucun slider trouvé dans la corbeille',
        'parent_item_colon'     => '' ,
        'all_items'             => 'Tout les Sliders'
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'exclude_from_search'   => false,
        'show_ui'               => true,
        'capability_type'       => 'post',
        'hierarchical'          => false,
        'rewrite'               => array( 'with_front' => false ),
        'query_var'             => false,
        'menu_position'         => null,
        'menu_icon'             => THEME_URI . '/framework/admin/images/slider-icon.png',
        'supports'              => array( 'title', 'thumbnail', 'page-attributes' )
    );

    register_post_type( 'slider', $args );
}
add_action('init', 'ep_custom_slider');
    register_taxonomy("slider_cat", 'slider', array(
    'hierarchical'      => true,
        'labels' => array(
            'name'              =>  'Catégories slider',
            'singular_name'     =>  'Sliders',
            'search_items'      =>  'Rechercher un slider',
            'all_items'         =>  'Tout les sliders',
            'parent_item'       =>  'Slider parent',
            'parent_item_colon' =>  'Slider parent :',
            'edit_item'         =>  'Éditer un slider',
            'update_item'       =>  'Mettre à jour',
            'add_new_item'      =>  'Ajouter une catégorie',
            'new_item_name'     =>  'Nouveau slider ',
            'menu_name'         =>  'Catégories slider',
        ),
    'show_ui'           => true,
    'query_var'         => true,
    'rewrite'           => false,
));

function slider_columns($columns) {
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'title'         => 'Title',
        'author'        => 'Author',
        'thumbnail'     => 'Thumbnails',
        'slider_cat'    => 'Categories',
        'date'          => 'Date',
    );
    return $columns;
}

function manage_slider_columns($name) {
    global $wpdb, $wp_query, $post;
    switch ( $name ) {
        case 'slider_cat':
            $terms = get_the_terms($post->ID, 'slider_cat');
            //If the terms array contains items... (dupe of core)
            if ( !empty($terms) ) {
                //Loop through terms
                foreach ( $terms as $term ){
                    //Add tax name & link to an array
                    $post_terms[] = esc_html(sanitize_term_field('name', $term->name, $term->term_id, '', 'edit'));
                }
                //Spit out the array as CSV
                echo implode( ', ', $post_terms );
            } else {
                //Text to show if no terms attached for post & tax
                echo '<em>No terms</em>';
            }
            break;
        case 'thumbnail':
            echo the_post_thumbnail(array(150,150));
                break;

    }
}
add_action( 'manage_slider_posts_custom_column', 'manage_slider_columns', 10, 2 );
add_filter( 'manage_edit-slider_columns', 'slider_columns' );
?>