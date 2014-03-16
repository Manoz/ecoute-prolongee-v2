<?php
/**
 * Podcasts meta box
 *
 * @package Écoute Prolongée
 * @since   1.0.0
*/

/* Checkbox field
    $html .= '<p><label><input type="checkbox" name="noindex"';
    $html .= (get_post_meta($post->ID, 'true_noindex',true) == 'on') ? ' checked="checked"' : '';
    $html .= ' /> Turn of page visibility for search engines</label></p>';
*/

/**
 * Podcasts URL meta box
 * @since 1.0.0
*/
add_action( 'admin_menu', 'ep_podcasts_add_metabox' );
function ep_podcasts_add_metabox() {
    add_meta_box(
        'podcasts_metabox',         // ID
        'Options Podcasts',         // Title
        'ep_display_podcasts_meta', // Callback
        'ep-podcasts',              // Post type
        'normal',                   // Position ('normal', 'advanced', 'side')
        'default'                   // Priority
    );
}

function ep_display_podcasts_meta($post) {
    // Security check
    wp_nonce_field( basename( __FILE__ ), 'podcasts_metabox_nonce' );

    // Add the html fields
    $html = '
        <p>
            <label for="youtube_url_field"><strong>URL de la vidéo :</strong></label><br><br>
            <input size="40" id="youtube_url_field" type="text" name="youtube_url_field" value="' . get_post_meta($post->ID, 'youtube_url',true) . '" placeholder="http://www.youtube.com/watch?v=XXXXXXXXXXX" />
        </p>
    ';

    // Print the stuff
    echo $html;
}

add_action( 'save_post', 'ep_save_podcasts_meta', 10, 2 );
function ep_save_podcasts_meta( $post_id, $post ) {
    // Security check
    if ( !isset( $_POST['podcasts_metabox_nonce'] ) || !wp_verify_nonce( $_POST['podcasts_metabox_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    // Check the user permissions
    $post_type = get_post_type_object( $post->post_type );
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    // Check the autosave
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if ($post->post_type == 'ep-podcasts') {
        update_post_meta($post_id, 'youtube_url', esc_attr($_POST['youtube_url_field']));
    }
    return $post_id;
}
