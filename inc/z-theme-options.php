<?php
/**
 * All theme settings
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
if ( !defined( 'ABSPATH' )) die('Love the blank page?');
/* Initialize the custom Theme Options.
 * Bbuild the custom settings & update OptionTree.
*/
add_action( 'admin_init', 'custom_theme_options', 1 );
function custom_theme_options() {
    // Get a copy of the saved settings array.
    $saved_settings = get_option( ot_settings_id(), array() );

    /**
    * Custom settings array that will eventually be
    * passes to the OptionTree Settings API Class.
    */
    $custom_settings = array(
        'contextual_help' => array(
            'content'           => array(
                array(
                    'id'        => 'general_help',
                    'title'     => 'Documentation',
                    'content'   => '<p><a href="http://www.mwanoz.fr/">http://www.mwanoz.fr/</a></p></p>'
                )
            ),
        ),
        'sections'          => array(
            array(
                'id'        => 'general',
                'title'     => 'G&eacute;n&eacute;ral'
            ),
            array(
                'id'        => 'homepage',
                'title'     => 'Page d\'accueil'
            ),
            array(
                'id'        => 'pl_settings',
                'title'     => 'Audio player'
            ),
            array(
                'id'        => 'social',
                'title'     => 'Réseaux sociaux'
            ),
            array(
                'id'        => 'divers',
                'title'     => 'Divers'
            )
        ), // End sections

        // Start the settings
        'settings'             => array(
            /*
             * This is a demo array with some settings.
             * We should build all the settings like this.

            array(
                'id'           => '',
                'label'        => '',
                'desc'         => '',
                'std'          => '',
                'type'         => '',
                'section'      => '',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'

            ),
            */

            // G E N E R A L   S E T T I N G S
            //--------------------------------------------------------
            array(
                'id'           => 'favicon_upload',
                'label'        => 'Uploader une favicon',
                'desc'         => 'Upload une image de 16*16px, .png ou .gif',
                'std'          => '',
                'type'         => 'upload',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'gestion_events',
                'label'        => 'D&eacute;sactiver l\'Agenda ?',
                'desc'         => '<p>D&eacute;sactiver les events sur la home ? Si il n\'y a aucun event dans les agendas, le module sur la home s\'affiche quand même.</p> <p>En attendant que je trouve une solution propre pour empêcher ça, tu peux les désactiver manuellement ici.</p>',
                'std'          => '',
                'type'         => 'checkbox',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and',
                'choices'      => array(
                    array(
                        'value'     => 'yes',
                        'label'     => 'Oui ! Oui ! Oui !',
                        'src'       => ''
                    )
                )
            ),
            array(
                'id'           => 'analytics_id',
                'label'        => 'Google Analytics ID',
                'desc'         => '<p>Mettre ici le code google analytics. Ex: UA-12345678-9</p>',
                'std'          => 'UA-XXXXXXXX-X',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'footer_copyright',
                'label'        => 'Copyright',
                'desc'         => '<p>Tu peux changer la mention copyright du site ( Copyright 2014 - Écoute Prolongée).</p>',
                'std'          => '&copy; Copyright 2014 - Écoute Prolongée',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'footer_copyright_left',
                'label'        => 'Texte sous le copyright',
                'desc'         => '<p>Tu peux changer le petit bout de texte qui sera placé sous le Copyright du site.</p>',
                'std'          => 'Les morceaux que nous publions ne nous appartiennent pas et sont la propriété de leurs auteurs respectifs. Nous les diffusons uniquement dans un but promotionnel.',
                'type'         => 'text',
                'section'      => 'general',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),

            // H O M E P A G E   S E T T I N G S
            //--------------------------------------------------------
            array(
                'id'           => 'help_textarea',
                'label'        => 'Lorem ipsum ta mère',
                'desc'         => '<p>Cet onglet sert &agrave; personnaliser tout ce qui se trouve sur la page d\'accueil. Tu peux y ajouter le contenu du bloc <strong>&Agrave; Propos</strong> et tu peux également changer la photo du bloc <strong>On soutient</strong>. Tout ce qui touche au calendrier se gère automatiquement. Tu n\'as rien besoin de faire dessus.</p>',
                'std'          => '',
                'type'         => 'textblock',
                'section'      => 'homepage',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'home_textarea',
                'label'        => 'Bloc &Agrave; propos',
                'desc'         => '',
                'std'          => '',
                'type'         => 'textarea',
                'section'      => 'homepage',
                'rows'         => '15',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'support_upload',
                'label'        => 'Image "On soutient"',
                'desc'         => '<p>Permet de changer l\'image <code>On soutient</code> de la page d\'accueil. <br>Taille recommandée : 420*195.</p>',
                'std'          => '',
                'type'         => 'upload',
                'section'      => 'homepage',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'support_url',
                'label'        => 'Cible du lien',
                'desc'         => '<p>Mettre ici l\'url de la cible de l\'image <code>On Soutient</code>.</p>',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'homepage',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'support_title',
                'label'        => 'Titre du lien',
                'desc'         => '<p>Mettre ici le titre qui s\'affichera quand on passera la souris sur l\'image.</p>',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'homepage',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),

            // P L A Y E R   S E T T I N G S
            //--------------------------------------------------------
            array(
                'id'           => 'pl_help',
                'label'        => '',
                'desc'         => '<p>Cet onglet sert &agrave; personnaliser tout ce qui touche au player audio du site. Tu peux changer les couleurs, quelques options et le volume par défaut.</p>',
                'std'          => '',
                'type'         => 'textblock',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_default_track',
                'label'        => 'Playlist par défaut',
                'desc'         => '<p>Tu peux mettre ici l\'URL de la track ou de la playlist qui se lancera par défaut quand on visite le site.</p>',
                'std'          => '',
                'type'         => 'text',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_opened',
                'label'        => 'Ouvert par défaut ?',
                'desc'         => 'Si le player est ouvert ou fermé au chargement du site.',
                'std'          => 'on',
                'type'         => 'on-off',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_autoplay',
                'label'        => 'Lecture automatique ?',
                'desc'         => 'Lance une playlist dès que le player est chargé',
                'std'          => 'off',
                'type'         => 'on-off',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_play_next',
                'label'        => 'Jouer la suite ?',
                'desc'         => 'Dès qu\'une track se termine, joue la suivante.',
                'std'          => 'on',
                'type'         => 'on-off',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_socials',
                'label'        => 'Boutons réseaux sociaux ?',
                'desc'         => 'Activer ou non les boutons de partage sur Twitter et Facebook.',
                'std'          => 'on',
                'type'         => 'on-off',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_keyboard',
                'label'        => 'Navigation au clavier ?',
                'desc'         => 'Activer ou non la navigation au clavier.',
                'std'          => 'on',
                'type'         => 'on-off',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_volume',
                'label'        => 'Volume par défaut ?',
                'desc'         => 'Le volume par défaut du player.',
                'std'          => '',
                'type'         => 'numeric-slider',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '0,1,0.1',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_wrap_color',
                'label'        => 'Couleur du wrapper',
                'desc'         => 'La couleur de fond du conteneur.',
                'std'          => '#f0f0f0',
                'type'         => 'colorpicker',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_main_color',
                'label'        => 'Couleur principale',
                'desc'         => 'La couleur principale du player.',
                'std'          => '#3c3c3c',
                'type'         => 'colorpicker',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_btn_bg_color',
                'label'        => 'Fond des boutons',
                'desc'         => 'La couleur de fond des boutons.',
                'std'          => '#e3e3e3',
                'type'         => 'colorpicker',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_meta_color',
                'label'        => 'Couleur des métas',
                'desc'         => 'La couleur des métas comme par exemple le texte sous le titre de la track etc...',
                'std'          => '#666666',
                'type'         => 'colorpicker',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_stroke_color',
                'label'        => 'Couleur des bordures',
                'desc'         => 'La couleur des bordures.',
                'std'          => '#e0e0e0',
                'type'         => 'colorpicker',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_btn_hover_color',
                'label'        => 'Fond des boutons hover',
                'desc'         => 'La couleur de fond des boutons quand on passe la souris dessus.',
                'std'          => '#d1d1d1',
                'type'         => 'colorpicker',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'id'           => 'pl_active_track_color',
                'label'        => 'Track en cours',
                'desc'         => 'La couleur de la track en cours.',
                'std'          => '#E8E8E8',
                'type'         => 'colorpicker',
                'section'      => 'pl_settings',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),


            // S O C I A L   S E T T I N G S
            //--------------------------------------------------------
            array(
                'id'           => 'about_social_networks',
                'label'        => '&Agrave; propos des réseaux sociaux',
                'desc'         => '<p>Mettre ici l\'url complète du r&eacute;seau social. Ces liens sont utilis&eacute; un peu partout dans le th&egrave;me. <br><span style="color: #bc4c40">Pour le moment, belek, cette section est désactiv&eacute;e.</span></p>',
                'std'          => '',
                'type'         => 'textblock-titled',
                'section'      => 'social',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            ),
            array(
                'label'        => 'Facebook',
                'id'           => 'social_fb',
                'type'         => 'text',
                'desc'         => 'URL compl&egrave;te',
                'std'          => '',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'class'        => '',
                'section'      => 'social'
            ),
            array(
                'label'        => 'Twitter',
                'id'           => 'social_tw',
                'type'         => 'text',
                'desc'         => 'URL compl&egrave;te',
                'std'          => '',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'class'        => '',
                'section'      => 'social'
            ),
            array(
                'label'        => 'Google+',
                'id'           => 'social_goog',
                'type'         => 'text',
                'desc'         => 'URL compl&egrave;te',
                'std'          => '',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'class'        => '',
                'section'      => 'social'
            ),
            array(
                'label'        => 'Soundcloud',
                'id'           => 'social_soundcloud',
                'type'         => 'text',
                'desc'         => 'URL compl&egrave;te',
                'std'          => '',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'class'        => '',
                'section'      => 'social'
            ),
            array(
                'label'        => 'Spotify',
                'id'           => 'social_spotify',
                'type'         => 'text',
                'desc'         => 'URL compl&egrave;te',
                'std'          => '',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'class'        => '',
                'section'      => 'social'
            ),
            array(
                'label'        => 'Grooveshark',
                'id'           => 'social_grooveshark',
                'type'         => 'text',
                'desc'         => 'URL compl&egrave;te',
                'std'          => '',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'class'        => '',
                'section'      => 'social'
            ),
            array(
                'label'        => 'Instagram',
                'id'           => 'social_instagram',
                'type'         => 'text',
                'desc'         => 'URL compl&egrave;te',
                'std'          => '',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'class'        => '',
                'section'      => 'social'
            ),
            array(
                'label'        => 'YouTube',
                'id'           => 'social_yt',
                'type'         => 'text',
                'desc'         => 'URL compl&egrave;te',
                'std'          => '',
                'rows'         => '',
                'post_type'    => '',
                'taxonomy'     => '',
                'class'        => '',
                'section'      => 'social'
            ),
            // D I V E R S   S E T T I N G S
            //--------------------------------------------------------
            array(
                'id'           => 'custom_css',
                'label'        => 'Custom CSS',
                'desc'         => '<p>Permet d\'ajouter du css perso. <strong>Cette option est désactivée pour le moment.</strong></p> <p>Permet également d\'utiliser des variables et ça, ... c\'est plutôt fat.</p>',
                'std'          => '',
                'type'         => 'css',
                'section'      => 'divers',
                'rows'         => '20',
                'post_type'    => '',
                'taxonomy'     => '',
                'min_max_step' => '',
                'class'        => '',
                'condition'    => '',
                'operator'     => 'and'
            )
        )
    );

    // Allow settings to be filtered before saving
    $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );

    // Settings are not the same update the DB
    if ( $saved_settings !== $custom_settings ) {
        update_option( ot_settings_id(), $custom_settings );
    }

}

?>