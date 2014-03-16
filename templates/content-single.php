<?php
/**
 * Single post template
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
    <header class="ep-post-header">
    <?php if ( has_post_thumbnail() ) { ?>
        <div class="ep-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php } ?>

        <h2 class="ep-post-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </h2>

        <ul class="ep-post-metas">
            <li class="date"><i class="icon-calendar"></i><time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time></li>
            <li class="author"><i class="icon-user"></i><?php the_author_posts_link(); ?></li>
            <?php if( get_the_category() ) { ?><li class="category"><i class="icon-folder"></i><?php the_category(' &middot; '); ?></li><?php } ?>
            <li class="comments-meta"><i class="icon-chat"></i><a href="<?php the_permalink(); ?>#comments"><?php comments_number('0 comment', '1 comment', '% comments'); ?></a></li>
        </ul>
    </header>

    <div class="ep-post-content">
        <?php the_content(); ?>
        <?php ep_content_nav(); ?>
    </div>

    <footer class="ep-post-footer">
        <ul class="footer-metas">
            <li class="tag-links"><?php
                $tags_list = get_the_tag_list( '', __( ' ', 'ecoute' ) );
                if ( $tags_list ) :
                    printf( __( '<span>Tags :</span> %1$s', 'ecoute' ), $tags_list );
                else :
                    _e( 'No tags', 'ecoute' );
                endif; ?>
            </li>
        </ul>
    </footer>
</article>
