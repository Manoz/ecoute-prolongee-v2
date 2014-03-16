<?php
/*
Template Name: Blog
*/
get_header(); ?>

    <header class="ep-sub-header">
        <h2>Blog</h2>
    </header>

    <div class="ep-inner">
        <div class="ep-main" role="main">
            <?php

                if ( have_posts() ) :

                    while (have_posts()) : the_post();

                        get_template_part('loop', get_post_format());

                    endwhile;

                    ep_page_nav();

                else:

                    get_template_part('404');

                endif;

            ?>
        </div>

        <?php get_sidebar(); ?>
    </div>

<?php get_footer();
