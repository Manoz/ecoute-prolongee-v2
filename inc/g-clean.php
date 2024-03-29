<?php
/**
 * Cleanup wp_head()
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 *
 * Remove feed links
 * Remove extra feed links
 * Remove RSD & Windows Live Writer links
 * Remove WP version
 * Remove nav links
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?');

function ep_clean_head() {
    // Originally from http://wpengineer.com/1438/wordpress-header/
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

    if (!class_exists('WPSEO_Frontend')) {
        remove_action('wp_head', 'rel_canonical');
        add_action('wp_head', 'ep_rel_canonical');
    }
}

function ep_rel_canonical() {
    global $wp_the_query;

    if (!is_singular()) {
        return;
    }

    if (!$id = $wp_the_query->get_queried_object_id()) {
        return;
    }

    $link = get_permalink($id);
    echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}
add_action('init', 'ep_clean_head');

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_false');

/**
 * Clean up language_attributes() used in <html> tag
 *
 * Remove dir="ltr"
 */
function ep_lang_attr() {
    $attributes = array();
    $output = '';

    if (is_rtl()) {
        $attributes[] = 'dir="rtl"';
    }

    $lang = get_bloginfo('language');

    if ($lang) {
        $attributes[] = "lang=\"$lang\"";
    }

    $output = implode(' ', $attributes);
    $output = apply_filters('ep_lang_attr', $output);

    return $output;
}
add_filter('language_attributes', 'ep_lang_attr');

/**
 * Clean up output of stylesheet <link> tags
 */
function ep_clean_style($input) {
    preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
    // Only display media if it is meaningful
    $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
    // Add a 4 spaces indent before <link...
    return '    <link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
add_filter('style_loader_tag', 'ep_clean_style');

/**
 * Add and remove body_class() classes
 */
function ep_body_class($classes) {
    // Add post/page slug
    if (is_single() || is_page() && !is_front_page()) {
        $classes[] = basename(get_permalink());
    }

  // Remove unnecessary classes
    $home_id_class = 'page-id-' . get_option('page_on_front');
    $remove_classes = array(
        'page-template-default',
        $home_id_class
    );
    $classes = array_diff($classes, $remove_classes);

    return $classes;
}
add_filter('body_class', 'ep_body_class');

/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function ep_embed_wrap($cache, $url, $attr = '', $post_ID = '') {
    return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', 'ep_embed_wrap', 10, 4);

/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function ep_caption($output, $attr, $content) {
    if (is_feed()) {
        return $output;
    }

    $defaults = array(
        'id'      => '',
        'align'   => 'alignnone',
        'width'   => '',
        'caption' => ''
    );

    $attr = shortcode_atts($defaults, $attr);

    // If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
    if ($attr['width'] < 1 || empty($attr['caption'])) {
        return $content;
    }

    // Set up the attributes for the caption <figure>
    $attributes  = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '' );
    $attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
    $attributes .= ' style="width: ' . (esc_attr($attr['width']) + 10) . 'px"';

    $output  = '<figure' . $attributes .'>';
    $output .= do_shortcode($content);
    $output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
    $output .= '</figure>';

    return $output;
}
add_filter('img_caption_shortcode', 'ep_caption', 10, 3);

/**
 * Remove unnecessary self-closing tags
 */
function ep_self_closing($input) {
    return str_replace(' />', '>', $input);
}
add_filter('get_avatar',          'ep_self_closing'); // <img />
add_filter('comment_id_fields',   'ep_self_closing'); // <input />
add_filter('post_thumbnail_html', 'ep_self_closing'); // <img />

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 */
function ep_nice_search() {
    global $wp_rewrite;
        if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
            return;
        }

    $search_base = $wp_rewrite->search_base;
    if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
        wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
        exit();
    }
}
if (current_theme_supports('nice-search')) {
    add_action('template_redirect', 'ep_nice_search');
}

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function ep_request_filter($query_vars) {
    if (isset($_GET['s']) && empty($_GET['s'])) {
        $query_vars['s'] = ' ';
    }

    return $query_vars;
}
add_filter('request', 'ep_request_filter');

/**
 * Don't return the default description in the RSS feed if it hasn't been changed
 */
function ep_default_desc($bloginfo) {
    $default_tagline = 'Just another WordPress site';
    return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter('get_bloginfo_rss', 'ep_default_desc');

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function ep_get_search_form($form) {
    $form = '';
    locate_template('/templates/searchform.php', true, false);
    return $form;
}
add_filter('get_search_form', 'ep_get_search_form');

/**
 * Remove wp version param from any enqueued scripts
 */
function ep_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'ep_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'ep_wp_ver_css_js', 9999 );