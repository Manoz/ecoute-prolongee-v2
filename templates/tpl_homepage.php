<?php
/*
Template Name: Homepage
*/
if ( !defined( 'ABSPATH' )) die('Love the blank page?');
if ( function_exists( 'get_option_tree') ) { $theme_options = get_option( 'option_tree' ); }

get_header(); ?>

            <div class="ep-slider">
                <?php echo do_shortcode("[metaslider id=715]"); ?>
            </div>

            <div class="ep-inner ep-cf">
                <div class="ep-col-home">
                    <div class="ep-about-home">
                        <h1>&Agrave; propos d'&Eacute;coute Prolong&eacute;e</h1>
                        <?php echo $theme_options['home_textarea']; ?>
                    </div>
                </div>

                <div class="ep-col-home-last">
                    <div class="ep-support-home ep-cf">
                        <h1>On soutient</h1>
                        <a title="<?php echo $theme_options['support_title']; ?>" target="_blank" href="<?php echo $theme_options['support_url']; ?>">
                            <img src="<?php echo $theme_options['support_upload']; ?>">
                        </a>
                    </div>

                <?php
                $check = get_option_tree('gestion_events',$theme_options);
                if ( $check != 'yes' ) { ?>

                    <div class="ep-agenda-home">
                        <ul>
                    <?php
                        $loop = new WP_Query( array( 'post_type' => 'ep-agenda', 'posts_per_page' => 10 ) );

                        while ( $loop->have_posts() ) : $loop->the_post();

                        $jour  = get_post_meta( get_the_ID(), 'ep_jour_value',  true);
                        $mois  = get_post_meta( get_the_ID(), 'ep_mois_value',  true);
                        $prix  = get_post_meta( get_the_ID(), 'ep_prix_value',  true);
                        $lieux = get_post_meta( get_the_ID(), 'ep_lieux_value', true);
                        $url   = get_post_meta( get_the_ID(), 'ep_url_value',   true);
                        $titre = get_the_title();
                    ?>

                            <li>
                                <div class="ep-event-date">
                                    <span class="ep-event-month"><?php echo $mois; ?></span>
                                    <span class="ep-event-day"><?php echo $jour; ?></span>
                                </div>
                                <div class="ep-event-content">
                                    <span class="ep-event-title">
                                        <a href="<?php echo $url; ?>" target="_blank" title="<?php echo $titre; ?>"><?php echo $titre; ?></a>
                                    </span>
                                    <span class="ep-event-location"><?php echo $lieux; ?></span>
                                    <span class="ep-event-price"><?php echo $prix; ?></span>
                                </div>
                            </li>
                        <?php endwhile; ?>

                        </ul> <!-- End liste des events -->
                    </div> <!-- End .ep-agenda-home -->
                <?php } ?>

                </div> <!-- End ep-col-home-last -->
                <div class="clear"></div>
            </div> <!-- End ep-inner -->
<?php get_footer();
