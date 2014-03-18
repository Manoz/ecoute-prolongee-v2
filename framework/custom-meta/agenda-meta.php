<?php
/**
 * Agenda meta box
 *
 * @package Écoute Prolongée
 * @since   1.0.0
*/
if ( !defined( 'ABSPATH' )) die('Love the blank page?');

/* Checkbox field
    $html .= '<p><label><input type="checkbox" name="noindex"';
    $html .= (get_post_meta($post->ID, 'true_noindex',true) == 'on') ? ' checked="checked"' : '';
    $html .= ' /> Turn of page visibility for search engines</label></p>';
*/

/**
 * Agenda meta box
 * @since 1.0.0
*/
add_action( 'admin_menu', 'ep_agenda_add_metabox' );
function ep_agenda_add_metabox() {
    add_meta_box(
        'agenda_metabox',            // ID
        'Infos des events',          // Title
        'ep_display_agenda_meta',    // Callback
        'ep-agenda',                 // Post type
        'normal',                    // Position ('normal', 'advanced', 'side')
        'default'                    // Priority
    );
}

function ep_display_agenda_meta( $post ) {
    // Security check
    wp_nonce_field( basename( __FILE__ ), 'agenda_metabox_nonce' );

    // Add the html fields
    $html = '
        <p>
            <label for="ep_mois_field"><strong>Le mois :</strong></label><br>
            <input size="40" id="ep_mois_field" type="text" name="ep_mois_field" value="' . get_post_meta($post->ID, 'ep_mois_value',true) . '" placeholder="Janvier, F&eacute;vrier, Mars, etc ..." />
        </p>
        <p>
            <label for="ep_jour_field"><strong>Le jour :</strong></label><br>
            <input size="40" id="ep_jour_field" type="text" name="ep_jour_field" value="' . get_post_meta($post->ID, 'ep_jour_value',true) . '" placeholder="En chiffre. Ex: 01, 02, etc ..." />
        </p>
        <p>
            <label for="ep_lieux_field"><strong>Le lieux :</strong></label><br>
            <input size="40" id="ep_lieux_field" type="text" name="ep_lieux_field" value="' . get_post_meta($post->ID, 'ep_lieux_value',true) . '" placeholder="Lieux de l\'event." />
        </p>
        <p>
            <label for="ep_prix_field"><strong>Le prix :</strong></label><br>
            <input size="40" id="ep_prix_field" type="text" name="ep_prix_field" value="' . get_post_meta($post->ID, 'ep_prix_value',true) . '" placeholder="Prix de l\'event. Ex: 25€" />
        </p>
        <p>
            <label for="ep_url_field"><strong>L\'url :</strong></label><br>
            <input size="40" id="ep_url_field" type="text" name="ep_url_field" value="' . get_post_meta($post->ID, 'ep_url_value',true) . '" placeholder="URL de l\'event." />
        </p>
    ';

    // Print the stuff
    echo $html;
}

add_action( 'save_post', 'ep_save_agenda_meta', 10, 2 );
function ep_save_agenda_meta( $post_id, $post ) {
    // Security check
    if ( !isset( $_POST['agenda_metabox_nonce'] ) || !wp_verify_nonce( $_POST['agenda_metabox_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    // Check the user permissions
    $post_type = get_post_type_object( $post->post_type );
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    // Check the autosave
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if( $post->post_type == 'ep-agenda' ) {
        update_post_meta( $post_id, 'ep_mois_value',  esc_attr( $_POST['ep_mois_field']  ) );
        update_post_meta( $post_id, 'ep_jour_value',  esc_attr( $_POST['ep_jour_field']  ) );
        update_post_meta( $post_id, 'ep_lieux_value', esc_attr( $_POST['ep_lieux_field'] ) );
        update_post_meta( $post_id, 'ep_prix_value',  esc_attr( $_POST['ep_prix_field']  ) );
        update_post_meta( $post_id, 'ep_url_value',   esc_attr( $_POST['ep_url_field']   ) );
    }
    return $post_id;
}
