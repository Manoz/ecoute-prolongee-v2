<?php
/*
Template Name: Agenda
*/
if ( !defined( 'ABSPATH' )) die('Love the blank page?');
get_header(); ?>

    <header class="ep-sub-header">
        <h2>Agenda</h2>
    </header>

    <div class="ep-inner">
        <div class="ep-main ep-cf" role="main">
            <div class="ep-event-list">
                <?php
                    $loop = new WP_Query( array( 'post_type' => 'ep-agenda', 'posts_per_page' => 10 ) );

                    while ( $loop->have_posts() ) : $loop->the_post();

                    $titre   = get_the_title();
                    $jour    = get_post_meta( get_the_ID(), 'ep_jour_value',  true);
                    $mois    = get_post_meta( get_the_ID(), 'ep_mois_value',  true);
                    $prix    = get_post_meta( get_the_ID(), 'ep_prix_value',  true);
                    $lieux   = get_post_meta( get_the_ID(), 'ep_lieux_value', true);
                    $url     = get_post_meta( get_the_ID(), 'ep_url_value',   true);
                    $soldout = get_post_meta( get_the_ID(), 'event_soldout',  true);
                    $tickets = get_post_meta( get_the_ID(), 'event_tickets',  true);
                ?>

                    <section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="event-date">
                            <span class="month"><?php echo $mois; ?></span>
                            <strong><?php echo $jour; ?></strong>
                        </div>
                        <div class="event-details">
                            <h2><a target="_blank" href="<?php echo $url; ?>" title="<?php echo $titre; ?>"><?php echo $titre; ?></a></h2>
                            <span><i class="icon-location"></i><?php echo $lieux; ?> - <strong><?php echo $prix; ?></strong></span>
                            <div class="event-buttons">
                            <?php
                                if( $soldout == 'on' ) {
                                    echo '<span class="sold-out">Sold Out</span>';
                                } elseif( $soldout == 'off' || empty( $soldout ) && !empty( $tickets ) ) {
                                    echo '<a target="_blank" href="'.$tickets.'">Acheter des places</a>';
                                }
                            ?>
                            </div>
                        </div>
                    </section>

                <?php endwhile;

            ?>

            </div>
        </div>
    </div>

<?php get_footer();
