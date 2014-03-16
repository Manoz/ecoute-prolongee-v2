<?php
/**
 * Podcast post template
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */

$video_url = get_post_meta( get_the_ID(), 'youtube_url',  true);  ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

    <header class="ep-post-header">
        <iframe width="960" height="540" src="<?php echo '//www.youtube.com/embed/' . $video_url . '?rel=0'; ?>" frameborder="0" allowfullscreen></iframe>
    </header>

    <div class="ep-post-content">
        <?php the_content(); ?>
    </div>

</article>
