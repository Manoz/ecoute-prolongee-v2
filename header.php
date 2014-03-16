<?php
/**
 * 'Start Here' head
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
?><!DOCTYPE HTML>
<!--[if lt IE 8 ]><html <?php language_attributes(); ?> class="is_ie7 lt_ie8 lt_ie9 lt_ie10"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="is_ie8 lt_ie9 lt_ie10"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="is_ie9 lt_ie10"><![endif]-->
<!--[if gt IE 9]><html <?php language_attributes(); ?> class="is_ie10"><![endif]-->
<!--[if !IE]><!--> <html <?php language_attributes(); ?>><!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <link rel="profile" href="http://gmpg.org/xfn/11" >
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" >

    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js"></script>
    <![endif]-->

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
<div class="ep-container">
    <header class="ep-header ep-cf" role="banner">
        <div class="ep-inner">
            <div class="ep-logo">
                <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <img alt="Logo Écoute Prolongée" src="<?php echo get_template_directory_uri(); ?>/images/logo.png">
                </a>
            </div>

            <div class="ep-nav-wrap" role="navigation">
            <?php
                if (has_nav_menu('primary_navigation')) :
                    wp_nav_menu( array(
                        'theme_location'    => 'primary_navigation',
                        'menu_class'        => 'nav ep-nav',
                        'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                    ));
                endif;
            ?>
            </div>
        </div>
    </header>

    <div class="ep-content">
