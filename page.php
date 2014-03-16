<?php
/**
 * Template for all Pages
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
get_header(); ?>

    <header class="ep-sub-header">
    <?php
        if ( have_posts() ) :
            while (have_posts()) : the_post();
            ?>
                <h2><?php the_title(); ?></h2>
            <?php
            endwhile;
        endif;
    ?>
    </header>

    <div class="ep-inner">
        <div class="ep-main ep-cf" role="main">

        <?php
            if ( have_posts() ) :

                while (have_posts()) : the_post();

                    get_template_part( 'templates/content', 'page' );

                endwhile;

            endif; ?>

        </div>
    </div>

<?php get_footer();