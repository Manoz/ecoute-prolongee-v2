<?php
/**
 * Our custom post meta box
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

/* =======================================================
 *                 P O D C A S T S
 * ======================================================= */

add_action( 'admin_menu', 'ep_podcasts_add_metabox' );
function ep_podcasts_add_metabox() {
    add_meta_box(
        'podcasts_metabox',
        'Options Podcasts',
        'ep_display_podcasts_meta',
        'podcasts',
        'normal',
        'default'
    );
}

function ep_display_podcasts_meta($post) {
    wp_nonce_field( basename( __FILE__ ), 'podcasts_metabox_nonce' );

    $html = '
        <p>
            <label for="youtube_url_field"><strong>URL de la vidéo :</strong></label><br><br>
            <input size="40" id="youtube_url_field" type="text" name="youtube_url_field" value="' . get_post_meta($post->ID, 'youtube_url',true) . '" placeholder="http://www.youtube.com/watch?v=XXXXXXXXXXX" />
        </p>
    ';

    echo $html;
}

add_action( 'save_post', 'ep_save_podcasts_meta', 10, 2 );
function ep_save_podcasts_meta( $post_id, $post ) {
    if ( !isset( $_POST['podcasts_metabox_nonce'] ) || !wp_verify_nonce( $_POST['podcasts_metabox_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    $post_type = get_post_type_object( $post->post_type );
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if ($post->post_type == 'podcasts') {
        update_post_meta($post_id, 'youtube_url', esc_attr($_POST['youtube_url_field']));
    }
    return $post_id;
}

/* =======================================================
 *                 P L A Y L I S T S
 * ======================================================= */

add_action( 'admin_menu', 'ep_playlists_add_metabox' );
function ep_playlists_add_metabox() {
    add_meta_box(
        'playlists_metabox',
        'URL des playlists',
        'ep_display_playlists_meta',
        'playlists',
        'normal',
        'default'
    );
}

function ep_display_playlists_meta($post) {
    wp_nonce_field( basename( __FILE__ ), 'playlists_metabox_nonce' );

    $html = '
        <p>
            <input size="95" id="soundcloud_url_field" type="text" name="soundcloud_url_field" value="' . get_post_meta($post->ID, 'soundcloud_url',true) . '" placeholder="URL de la playlist Soundcloud" />
        </p>
        <p>
            <input size="95" id="grooveshark_url_field" type="text" name="grooveshark_url_field" value="' . get_post_meta($post->ID, 'grooveshark_url',true) . '" placeholder="URL de la playlist Grooveshark" />
        </p>
        <p>
            <input size="95" id="spotify_url_field" type="text" name="spotify_url_field" value="' . get_post_meta($post->ID, 'spotify_url',true) . '" placeholder="URL de la playlist Spotify" />
        </p>
    ';

    echo $html;
}

add_action( 'save_post', 'ep_save_playlist_meta', 10, 2 );
function ep_save_playlist_meta( $post_id, $post ) {
    if ( !isset( $_POST['playlists_metabox_nonce'] ) || !wp_verify_nonce( $_POST['playlists_metabox_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    $post_type = get_post_type_object( $post->post_type );
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if ($post->post_type == 'playlists') {
        update_post_meta($post_id, 'soundcloud_url', esc_attr($_POST['soundcloud_url_field']));
        update_post_meta($post_id, 'grooveshark_url', esc_attr($_POST['grooveshark_url_field']));
        update_post_meta($post_id, 'spotify_url', esc_attr($_POST['spotify_url_field']));
    }
    return $post_id;
}

/**
 * Playlists Infos meta box
 * @since 1.0.0
*/
add_action( 'admin_menu', 'ep_playlistsinfo_add_metabox' );
function ep_playlistsinfo_add_metabox() {
    add_meta_box(
        'playlistsinfos_metabox',
        'Infos des playlists',
        'ep_display_playlistsinfos_meta',
        'playlists',
        'normal',
        'default'
    );
}

function ep_display_playlistsinfos_meta($post) {
    wp_nonce_field( basename( __FILE__ ), 'playlistsinfos_metabox_nonce' );

    $html = '
        <p>
            <input size="95" id="playlist_title_field" type="text" name="playlist_title_field" value="' . get_post_meta($post->ID, 'playlist_title',true) . '" placeholder="Titre de la playlist" />
        </p>
        <p>
            <input size="50" id="playlist_genre_field" type="text" name="playlist_genre_field" value="' . get_post_meta($post->ID, 'playlist_genre',true) . '" placeholder="Genre musical de la playlist" />
        </p>
    ';

    echo $html;
}

add_action( 'save_post', 'ep_save_playlistsinfos_meta', 10, 2 );
function ep_save_playlistsinfos_meta( $post_id, $post ) {
    if ( !isset( $_POST['playlistsinfos_metabox_nonce'] ) || !wp_verify_nonce( $_POST['playlistsinfos_metabox_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    $post_type = get_post_type_object( $post->post_type );
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if ($post->post_type == 'playlists') {
        update_post_meta($post_id, 'playlist_title', esc_attr($_POST['playlist_title_field']));
        update_post_meta($post_id, 'playlist_genre', esc_attr($_POST['playlist_genre_field']));
    }
    return $post_id;
}
