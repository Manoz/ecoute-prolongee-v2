<?php
/*
Template Name: Playlists
*/
if ( !defined( 'ABSPATH' )) die('Love the blank page?');
get_header(); ?>

    <header class="ep-sub-header">
        <h2>Playlists</h2>
    </header>

    <div class="ep-inner">
        <div class="ep-main ep-cf" role="main">
        <?php

            $loop = new WP_Query( array( 'post_type' => 'ep-playlists', 'posts_per_page' => 10 ) );

            while ( $loop->have_posts() ) : $loop->the_post();

                $soundcloud  = get_post_meta( get_the_ID(), 'soundcloud_url',  true);
                $grooveshark = get_post_meta( get_the_ID(), 'grooveshark_url', true);
                $spotify     = get_post_meta( get_the_ID(), 'spotify_url',     true);
                $genre       = get_post_meta( get_the_ID(), 'playlist_genre',  true);
            ?>

            <div class="ep-playlist-col ep-cf">
                <div class="playlist-thumb"><?php the_post_thumbnail(); ?></div>
                    <div class="playlist-btn-icons">
                        <?php if( !empty( $soundcloud ) ) { ?> <a href="<?php echo $soundcloud; ?>" target="_blank"><i class="icon-soundcloud"></i></span></a> <?php } ?>
                        <?php if( !empty( $grooveshark ) ) { ?> <a href="<?php echo $grooveshark; ?>" target="_blank"><i class="icon-grooveshark"></i></span></a> <?php } ?>
                        <?php if( !empty( $spotify ) ) { ?> <a href="<?php echo $spotify; ?>" target="_blank"><i class="icon-spotify"></i></span></a> <?php } ?>
                    </div>

                <div class="playlist-infos">
                    <div class="playlist-play">
                        <a href="<?php if( !empty( $soundcloud ) ) { echo $soundcloud; } elseif( !empty( $grooveshark ) ) { echo $grooveshark; } ?>" title="<?php the_title(); ?>" target="_blank"><div class="ep-play-btn"></div></a>
                    </div>
                    <h2 class="playlist-title ep-cf"><?php the_title(); ?></h2>
                    <span class="playlist-genre"><?php echo $genre; ?></span>
                </div>

            </div>

            <?php endwhile;

        ?>
        </div>
    </div>

<?php get_footer();