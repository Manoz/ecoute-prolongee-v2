<?php
/**
 * Slider meta box
 *
 * @package Écoute Prolongée
 * @since   1.0.0
*/

function ep_slider_meta_box() {
    $prefix = '';

    $this->meta_box[] = array(
        'id'        => 'slider-meta-box',
        'title'     => 'Écoute Prolongée - Options de la slide',
        'page'      => array('slider'),
        'context'   => 'normal',
        'priority'  => 'high',
        'fields'    => array(
            array(
                'name'      => 'Lien de la slide',
                'id'        => $prefix . 'postlinktype_options',
                'desc'      => 'L\'url à laquelle est liée la slide',
                'type'      => 'select',
                'std'       => 'nolink',
                'options'   => array(
                    'linkpage'      => 'Lier à une page',
                    'linktocategory'=> 'Lier à une catégorie',
                    'linktopost'    => 'Lier à un article',
                    'linkmanually'  => 'Lier manuellement',
                    'nolink'        => 'Belek le lien'
                )
            ),

            array(
                'name'      => 'Choisir une page',
                'desc'      => 'La page qui sera liée à la slider',
                'id'        => $prefix.'linkpage',
                'class'     => 'linkoption linkpage',
                'options'   => $this->ep_variable('pages'),
                'std'       => '',
                'type'      => 'select'
            ),
            array(
                'name'      => 'Choisir une catégorie',
                'desc'      => 'La catégorie qui sera liée à la slide',
                'id'        => $prefix.'linktocategory',
                'class'     => 'linkoption linktocategory',
                'std'       => '',
                'options'   =>  $this->ep_variable('categories'),
                'type'      => 'select'
            ),
            array(
                'name'      => 'Choisir un article',
                'desc'      => 'L\'article qui sera lié à la slide',
                'id'        => $prefix.'linktopost',
                'class'     => 'linkoption linktopost',
                'std'       => '',
                'options'   =>  $this->ep_variable('postlink'),
                'type'      => 'select'
            ),
            array(
                'name'  => 'Insérer un lien',
                'desc'  => 'Lien qui sera lié à la slide',
                'id'    => $prefix.'linkmanually',
                'class' => 'linkoption linkmanually',
                'std'   => '',
                'type'  => 'text'
            ),

            array(
                'name'  => 'Description de la slide',
                'desc'  => 'Je recommande de ne pas en mettre pour le moment.',
                'id'    => $prefix.'slider_desc',
                'class' => '',
                'std'   => '',
                'type'  => 'textarea'
            ),
            array(
                'name'  => 'Désactiver la description',
                'desc'  => 'Coche si tu veux désactiver la description sur la slide.',
                'id'    => $prefix.'desc_enable',
                'std'   => 'off',
                'type'  => 'checkbox',
            ),
        ),
    );
}

function ep_variable( $type ) {

    $options = array();

    switch( $type ){
        case 'pages': // Get Page Titles
                $ep_entries = get_pages( 'sort_column=post_parent,menu_order' );
                foreach ( $ep_entries as $atpPage ) {
                    $options[$atpPage->ID] = $atpPage->post_title;
                }
                break;
        case 'slider': // Get Slider Slug and Name
                $ep_entries = get_terms( 'slider_cat', 'orderby=name&hide_empty=0' );
                foreach ( $ep_entries as $atpSlider ) {
                    $options[$atpSlider->slug] = $atpSlider->name;
                    $slider_ids[] = $atpSlider->slug;
                }
                break;
        case 'posts': // Get Posts Slug and Name
                $ep_entries = get_categories( 'hide_empty=0' );
                foreach ( $ep_entries as $atpPosts ) {
                    $options[$atpPosts->slug] = $atpPosts->name;
                    $ep_posts_ids[] = $atpPosts->slug;
                }
                break;
        case 'categories':
                $ep_entries = get_categories('hide_empty=true');
                foreach ($ep_entries as $ep_posts) {
                    $options[$ep_posts->term_id] = $ep_posts->name;
                    $ep_posts_ids[] = $ep_posts->term_id;
                }
                break;
        case 'postlink': // Get Posts Slug and Name
                $ep_entries = get_posts( 'hide_empty=0');
                foreach ( $ep_entries as $atpPosts ) {
                    $options[$atpPosts->ID] = $atpPosts->post_title;
                    $ep_posts_ids[] = $atpPosts->slug;
                }
                break;
        case 'events': // Get Events Slug and Name
                $ep_entries = get_terms( 'events_cat','orderby=name&hide_empty=0' );
                if(is_array($ep_entries)){
                    foreach ( $ep_entries as $atpEvents ) {
                        $options[$atpEvents->slug] = $atpEvents->name;
                        $eventsvalue_id[] = $atpEvents->slug;
                    }
                }
                break;
        case 'testimonial': // Get Testimonial Slug and Name
                $ep_entries = get_terms( 'testimonial_cat', 'orderby=name&hide_empty=0' );
                foreach ( $ep_entries as $atpTestimonial ) {
                    $options[$atpTestimonial->slug] = $atpTestimonial->name;
                    $testimonialvalue_id[] = $atpTestimonial->slug;
                }
                break;
        case 'tags': // Get Taxonomy Tags
                $ep_entries = get_tags( array( 'taxonomy' => 'post_tag' ) );
                foreach ( $ep_entries as $atpTags ) {
                    $options[$atpTags->slug] = $atpTags->name;
                }
                break;
        case 'slider_type': // Slider Arrays for Theme Options
            $options = array(
                ''              => 'Select Slider',
                'flexslider'    => 'Flex Slider',
                'videoslider'   => 'Single Video',
                'static_image'  => 'Static Image',
                'customslider'  => 'Custom Slider'
            );
            break;
    }

    return $options;
}