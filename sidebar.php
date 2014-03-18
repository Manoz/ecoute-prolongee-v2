<?php
/**
 * 'Start Here' sidebar stuff
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?'); ?>
<div class="ep-sidebar" role="complementary">
    <div class="ep-widgets-wrap">
    <?php
        do_action( 'before_sidebar' );
        if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

        <aside class="ep-widget">
            <?php get_search_form(); ?>
        </aside>

        <aside class="ep-widget">
            <h1 class="widget-title"><?php _e( 'Archives', 'ecoute' ); ?></h1>
            <ul>
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
        </aside>

        <aside class="ep-widget">
            <h1 class="widget-title"><?php _e( 'Meta', 'ecoute' ); ?></h1>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </aside>
    <?php endif; ?>
    </div>
</div>