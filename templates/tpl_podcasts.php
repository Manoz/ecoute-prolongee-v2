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

                $video_url = get_post_meta( get_the_ID(), 'youtube_url',  true);
            ?>

            <div class="ep-playlist-col ep-cf">
                <div class="playlist-thumb"><?php the_post_thumbnail(); ?></div>

                <div class="playlist-infos">
                    <div class="playlist-play">
                        <a href="<?php if( !empty( $video_url ) ) { echo $video_url; } ?>" title="<?php the_title(); ?>" target="_blank"><div class="ep-play-btn"></div></a>
                    </div>
                    <h2 class="playlist-title ep-cf"><?php the_title(); ?></h2>
                </div>

            </div>

            <?php endwhile;

        ?>
        </div>
    </div>

<?php get_footer();