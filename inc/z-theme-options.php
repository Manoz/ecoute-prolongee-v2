<?php
/**
 * Initialize the options before anything else.
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
    /**
    * Get a copy of the saved settings array.
    */
    $saved_settings = get_option( 'option_tree_settings', array() );

  /**
   * Custom settings array that will eventually be
   * passes to the OptionTree Settings API Class.
   */
    $custom_settings = array(
        'contextual_help' => array(
            'content'       => array(
                array(
                    'id'        => 'general_help',
                    'title'     => 'Documentation',
                    'content'   => '<p><a href="http://www.mwanoz.fr/">http://www.mwanoz.fr/</a></p></p>'
                )
            ),
            //'sidebar'       => '<p><a href="http://www.mwanoz.fr/">http://www.mwanoz.fr/</a></p>',
        ),
        'sections'        => array(
            array(
                'id'          => 'general',
                'title'       => 'General settings'
            ),
            array(
                'id'          => 'colors',
                'title'       => 'Colors options'
            ),
            array(
                'id'          => 'template',
                'title'       => 'Template options'
            ),
            array(
                'id'          => 'social',
                'title'       => 'Social networks'
          )
        ), // End sections

        // General settings
        'settings'        => array(
            array(
                'label'       => 'Favicon Upload',
                'id'          => 'favicon_upload',
                'type'        => 'upload',
                'desc'        => 'Upload a 16*16px .png or .gif image.',
                'std'         => '',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'class'       => '',
                'section'     => 'general'
            ),
            array(
                'label'         => 'Your custom CSS',
                'id'            => 'custom_css',
                'type'          => 'textarea-simple',
                'desc'          => 'If you want to customize Hugo, paste your css code here.',
                'std'           => '',
                'post_type'     => '',
                'taxonomy'      => '',
                'class'         => '',
                'section'       => 'general'
            ),
            array(
                'label'         => 'Disable Google Analytics?',
                'id'            => 'add_analytics',
                'type'          => 'checkbox',
                'desc'          => 'Check if you want to disable the Google Analytics code.',
                'choices'       => array(
                    array(
                        'label'     => 'Yes',
                        'value'     => 'Yes'
                    )
                ),
                'std'           => '',
                'rows'          => '',
                'post_type'     => '',
                'taxonomy'      => '',
                'class'         => '',
                'section'       => 'general'
            ),
            array(
                'label'         => 'Google Analytics ID',
                'id'            => 'analytics_id',
                'type'          => 'text',
                'desc'          => 'Paste your Google Analytics ID. Ex: UA-12345678-9',
                'std'           => 'UA-XXXXXXXX-X',
                'rows'          => '',
                'post_type'     => '',
                'taxonomy'      => '',
                'class'         => '',
                'section'       => 'general'
            ),
            // Color options
            array(
                'label'       => 'Theme Colors',
                'id'          => 'theme_colors',
                'type'        => 'select',
                'desc'        => 'Select your global theme colors.',
                'choices'     => array(
                    array(
                        'label'       => 'Default',
                        'value'       => 'main'
                    ),
                    array(
                        'label'       => 'Red',
                        'value'       => 'red'
                    ),
                    array(
                        'label'       => 'Green',
                        'value'       => 'green'
                    ),
                    array(
                        'label'       => 'Pink',
                        'value'       => 'pink'
                    ),
                    array(
                        'label'       => 'Orange',
                        'value'       => 'orange'
                    )
                ),
                'std'         => 'main',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'class'       => '',
                'section'     => 'colors'
            ),
            array(
                'label'         => 'Custom Theme Color',
                'id'            => 'custom_theme_color',
                'type'          => 'colorpicker',
                'desc'          => 'If you dont like my colour schemes, you can choose your own color here.',
                'std'           => '',
                'rows'          => '',
                'post_type'     => '',
                'taxonomy'      => '',
                'class'         => '',
                'section'       => 'colors'
            ),
            // Template settings
            array(
                'label'       => 'Homepage layout.',
                'id'          => 'homepage_layout',
                'type'        => 'radio-image',
                'desc'        => 'Choose the layout for the homepage. You will find the posts and pages layouts where you usually write.',
                'choices'     => array(
                    array(
                        'value'     => 'left-sidebar',
                        'label'     => 'Left sidebar',
                        'src'       => OT_URL . '/assets/images/layout/2cl.png'
                    ),
                    array(
                        'value'     => 'full-width',
                        'label'     => 'Full width',
                        'src'       => OT_URL . '/assets/images/layout/1col.png'
                    ),
                    array(
                        'value'     => 'right-sidebar',
                        'label'     => 'Right sidebar',
                        'src'       => OT_URL . '/assets/images/layout/2cr.png'
                    )
                ),
                'std'         => 'left-sidebar',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'class'       => '',
                'section'     => 'template'
            ),
            array(
                'label'         => 'Show top bar?',
                'id'            => 'show_top_bar',
                'type'          => 'checkbox',
                'desc'          => 'Check if you want to show the top bar.',
                'choices'       => array(
                    array(
                        'label'     => 'Yes',
                        'value'     => 'Yes'
                    )
                ),
                'std'           => 'Yes',
                'section'       => 'template'
            ),
            array(
                'label'         => 'Show dot title?',
                'id'            => 'title_dot',
                'type'          => 'checkbox',
                'desc'          => 'Show the dot after the site title?',
                'choices'       => array(
                    array(
                        'label'     => 'Yes',
                        'value'     => 'Yes'
                    )
                ),
                'std'           => 'Yes',
                'section'       => 'template'
            ),
            array(
                'label'         => 'Show top bar search?',
                'id'            => 'top_bar_search',
                'type'          => 'checkbox',
                'desc'          => 'Check if you want to show the search in the top bar.',
                'choices'       => array(
                    array(
                        'label'     => 'Yes',
                        'value'     => 'Yes'
                    )
                ),
                'std'           => 'Yes',
                'section'       => 'template'
            ),
            array(
                'label'         => 'Show top bar social networks?',
                'id'            => 'top_bar_social',
                'type'          => 'checkbox',
                'desc'          => 'Check if you want to show the social networks widget in the top bar.',
                'choices'       => array(
                    array(
                        'label'     => 'Yes',
                        'value'     => 'Yes'
                    )
                ),
                'std'           => 'Yes',
                'section'       => 'template'
            ),
            // Social networks
            array(
                'label'         => 'About Social Networks',
                'id'            => 'about_social_networks',
                'type'          => 'textblock-titled',
                'desc'          => '<p>Paste the <strong>full URL</strong> of the social network you want to display. <br>If there is no url, the icon will not appear.</p> <p>The icons will appear in the <em>top bar</em> and in the <em>footer widget</em>. In the <em>Template options</em> tab, you can choose whether to display the icons in the top bar section of the site.</p>',
                'section'       => 'social'
            ),
            array(
                'label'         => 'Facebook',
                'id'            => 'social_fb',
                'type'          => 'text',
                'desc'          => 'Enter your full URL',
                'std'           => '',
                'rows'          => '',
                'post_type'     => '',
                'taxonomy'      => '',
                'class'         => '',
                'section'       => 'social'
            ),
            array(
                'label'         => 'Twitter',
                'id'            => 'social_tw',
                'type'          => 'text',
                'desc'          => 'Enter your full URL',
                'std'           => '',
                'rows'          => '',
                'post_type'     => '',
                'taxonomy'      => '',
                'class'         => '',
                'section'       => 'social'
            ),
            array(
                'label'         => 'Google+',
                'id'            => 'social_goog',
                'type'          => 'text',
                'desc'          => 'Enter your full URL',
                'std'           => '',
                'rows'          => '',
                'post_type'     => '',
                'taxonomy'      => '',
                'class'         => '',
                'section'       => 'social'
            ),
            array(
                'label'         => 'YouTube',
                'id'            => 'social_yt',
                'type'          => 'text',
                'desc'          => 'Enter your full URL',
                'std'           => '',
                'rows'          => '',
                'post_type'     => '',
                'taxonomy'      => '',
                'class'         => '',
                'section'       => 'social'
            )
        )
    );

  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings );
  }

}

?>