<?php
/*
Template Name: Podcasts
*/
get_header(); ?>

    <header class="ep-sub-header">
        <h2>Podcasts</h2>
    </header>

    <div class="ep-inner">
        <div class="ep-main ep-cf" role="main">
        <?php

            $loop = new WP_Query( array( 'post_type' => 'ep-podcasts', 'posts_per_page' => 10 ) );

            while ( $loop->have_posts() ) : $loop->the_post();
            ?>

            <div class="ep-playlist-col ep-cf">
                <div class="playlist-thumb"><?php the_post_thumbnail(); ?></div>
                <div class="podcast-play">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><div class="ep-play-btn"></div></a>
                </div>
                <div class="podcast-infos">
                    <h2 class="podcast-title ep-cf"><?php the_title(); ?></h2>
                </div>

            </div>

            <?php endwhile;

        ?>
        </div>
    </div>

<?php get_footer();