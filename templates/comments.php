<?php
/**
 * The template for displaying Comments.
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

if ( post_password_required() ) return;
?>
<div id="comments" class="ep-comments-area">
    <?php if ( have_comments() ) : ?>

        <h2 class="comments-title"><?php printf( _n( 'One comment.', '%1$s comments.', get_comments_number(), 'ecoute' ), number_format_i18n( get_comments_number() )); ?></h2>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
            <h1 class="assistive-text"><?php _e( 'Comment navigation', 'ecoute' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'ecoute' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ecoute' ) ); ?></div>
        </nav>
        <?php endif; ?>

        <ul class="commentlist">
            <?php
                wp_list_comments( array( 'callback' => 'ep_comment' ) );
            ?>
        </ul>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
            <h1 class="assistive-text"><?php _e( 'Comment navigation', 'ecoute' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'ecoute' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ecoute' ) ); ?></div>
        </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php
        if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
        <p class="nocomments"><?php _e( 'Comments are closed.', 'ecoute' ); ?></p>
    <?php endif;
        $comments_args = array(
            'comment_notes_after' => '',
            // You can add your comments settings here
            // See http://codex.wordpress.org/Function_Reference/comment_form
        );
        comment_form($comments_args);
    ?>
</div>
<div class="clear"></div>