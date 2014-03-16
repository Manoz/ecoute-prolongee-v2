<?php
/**
 * Custom comments template.
 *
 * @todo Build a better reply link
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( ! function_exists( 'ep_comment' ) ) :
function ep_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="post pingback">
        <p><?php _e( 'Pingback:', 'ecoute' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'ecoute' ), ' ' ); ?></p>
    <?php
            break;
        default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body ep-cf">
            <div class="comment-details">
                <div class="comment-avatar">
                    <?php echo get_avatar( $comment, 60 ); ?>
                </div>

                <section class="comment-author vcard">
                    <cite class="author"><?php echo get_comment_author_link(); ?></cite>
                    <time pubdate datetime="<?php comment_time( 'c' ); ?>">
                        <a class="comment-time" href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php printf( __( '%1$s at %2$s', 'ecoute' ), get_comment_date(), get_comment_time() ); ?></a>
                    </time>
                    <?php edit_comment_link(__('(Edit)', 'ecoute'), '', ''); ?>
                    <span class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
                </section>

                <section class="comment-content">
                    <div class="comment-text">
                        <?php comment_text(); ?>
                    </div>
                </section>

                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="moderation clearfix"><?php _e('Your comment is awaiting moderation.', 'ecoute'); ?></em>
                    <br />
                <?php endif; ?>
            </div>
        </div>
    <?php
            break;
    endswitch;
}
endif;

/*
 * Replace the default "reply" link to "Reply to 'Author' "
 */
function ep_reply_link($link, $args, $comment){

    $comment = get_comment( $comment );

    // If no comment author is blank, use 'Anonymous'
    if ( empty($comment->comment_author) ) {
        if (!empty($comment->user_id)){
            $user=get_userdata($comment->user_id);
            $author=$user->user_login;
        } else {
            $author = __('Anonymous', 'ecoute');
        }
    } else {
        $author = $comment->comment_author;
    }

    // If the user provided more than a first name, use only first name
    if(strpos($author, ' ')){
        $author = substr($author, 0, strpos($author, ' '));
    }

    // Replace Reply Link with "Reply to &lt;Author First Name>"
    $reply_link_text = $args['reply_text'];
    $text = __('Reply to ', 'ecoute');
    $link = str_replace($reply_link_text, $text . $author, $link);

    return $link;
}
add_filter('comment_reply_link', 'ep_reply_link', 10, 3);