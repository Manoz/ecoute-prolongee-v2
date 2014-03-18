<?php
/**
 * Pages template
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?'); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
    <?php if ( has_post_thumbnail() ) { ?>
    <header class="ep-post-header">
        <div class="ep-thumbnail">
            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
        </div>
    </header>
    <?php } ?>

    <div class="ep-post-content">
        <?php the_content(); ?>
        <?php ep_content_nav(); ?>
    </div>

</article>
