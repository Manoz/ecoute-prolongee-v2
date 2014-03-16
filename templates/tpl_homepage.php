<?php
/*
Template Name: Homepage
*/
if ( function_exists( 'get_option_tree') ) { $theme_options = get_option( 'option_tree' ); }

get_header(); ?>

            <div class="ep-slider">
                <img style="border-bottom: 7px solid #cbd1d1;" src="http://www.ecoute-prolongee.com/wp-content/uploads/2014/03/lancement.jpg" >
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
                    <div class="ep-agenda-home">
                        <ul>
                            <li>
                                <div class="ep-event-date">
                                    <span class="ep-event-month">mars</span>
                                    <span class="ep-event-day">13</span>
                                </div>
                                <div class="ep-event-content">
                                    <span class="ep-event-title">
                                        <a href="https://www.facebook.com/events/447282505404215/" target="_blank" title="LIGHT YOUR BODY / Georges Cauld &amp; Stonn Residency">LIGHT YOUR BODY / Georges Cauld &amp; Stonn Residency</a>
                                    </span>
                                    <span class="ep-event-location">DV1</span>
                                    <span class="ep-event-price">2€</span>
                                </div>
                            </li>
                            <li>
                                <div class="ep-event-date">
                                    <span class="ep-event-month">mars</span>
                                    <span class="ep-event-day">18</span>
                                </div>
                                <div class="ep-event-content">
                                    <span class="ep-event-title">
                                        <a href="https://www.facebook.com/events/789764841053334/?ref_dashboard_filter=upcoming" target="_blank" title="MTR#006: ABDULLA RASHIM live - STANISLAV TOLKACHEV live - PALMA SOUND SYSTEM live - CLFT MILITIA">MTR#006: ABDULLA RASHIM live - STANISLAV TOL...</a>
                                    </span>
                                    <span class="ep-event-location">La Plateforme</span>
                                    <span class="ep-event-price">10€</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

<?php
get_footer();