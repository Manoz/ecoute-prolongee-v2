<?php
/**
 * Audio player settings
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?');

/*
 * All the audio player options are prefixed with pl_ (means 'PLayer')
 * Ex: pl_wrap_pos for the wrapper position.
*/
$pl_opened    = ( $theme_options['pl_opened']    == 'on' ) ? 'true' : 'false';
$pl_autoplay  = ( $theme_options['pl_autoplay']  == 'on' ) ? 'true' : 'false';
$pl_play_next = ( $theme_options['pl_play_next'] == 'on' ) ? 'true' : 'false';
$pl_socials   = ( $theme_options['pl_socials']   == 'on' ) ? 'true' : 'false';
$pl_keyboard  = ( $theme_options['pl_keyboard']  == 'on' ) ? 'true' : 'false';

?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        soundManager.url = '<?php echo get_template_directory_uri();?>/inc/swf/';
        soundManager.flashVersion = 9;
        soundManager.useHTML5Audio = true;
        soundManager.debugMode = false;

        $('#fap').fullwidthAudioPlayer({
            wrapperPosition: 'bottom',
            mainPosition: 'center',
            twitterText: 'Tweeter',
            facebookText: 'Partager sur Facebook',
            opened: <?php echo $pl_opened; ?>,
            autoPlay: <?php echo $pl_autoplay; ?>,
            playNextWhenFinished: <?php echo $pl_play_next; ?>,
            socials: <?php echo $pl_socials; ?>,
            keyboard: <?php echo $pl_keyboard; ?>,
            wrapperColor: '<?php echo "$theme_options[pl_wrap_color]"; ?>',
            mainColor: '<?php echo "$theme_options[pl_main_color]"; ?>',
            fillColor: '<?php echo "$theme_options[pl_btn_bg_color]"; ?>',
            metaColor: '<?php echo "$theme_options[pl_meta_color]"; ?>',
            strokeColor: '<?php echo "$theme_options[pl_stroke_color]"; ?>',
            fillColorHover: '<?php echo "$theme_options[pl_btn_hover_color]"; ?>',
            activeTrackColor: '<?php echo "$theme_options[pl_active_track_color]"; ?>'
        });

        jQuery('#fap').bind('onFapReady', function(evt, trackData) {
            jQuery.fullwidthAudioPlayer.volume(<?php echo $theme_options['pl_volume']; ?>);
        });

    });
</script>