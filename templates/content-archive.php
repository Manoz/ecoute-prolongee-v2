<?php
/**
 * Category/Archives template
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('ep-cf'); ?> >
    <header class="ep-post-header">
    <?php if ( has_post_thumbnail() ) { ?>
        <div class="ep-thumbnail">
            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </div>
    <?php } ?>

        <h2 class="ep-post-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </h2>

        <ul class="ep-post-metas">
            <li class="date"><i class="icon-calendar"></i><time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time></li>
            <li class="author"><i class="icon-user"></i><?php the_author_posts_link(); ?></li>
        </ul>
    </header>

    <div class="ep-post-content">
        <?php the_excerpt(); ?>
        <a class="read-more" href="<?php the_permalink(); ?>" title="<?php echo _e( 'Read more', 'ecoute' ); ?>"><?php echo _e( 'Read more', 'ecoute' ); ?></a>
    </div>

</article>
