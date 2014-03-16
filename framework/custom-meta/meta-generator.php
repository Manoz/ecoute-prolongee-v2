<?php
/**
 * Custom meta boxes
 *
 * @package Écoute Prolongée
 * @since   1.0.0
*/
class EP_Custom_Fields {
    function __construct( $meta_box ) {
        $this->_meta_box = $meta_box;
        add_action( 'save_post', array( &$this, 'savemeta' ), 10, 2 );
        add_action( 'admin_enqueue_scripts', array( &$this, 'ep_admin_enqueue' ) );
        add_action( 'admin_head', array( &$this, 'plupload_admin_head' ) );
        add_action( 'wp_ajax_plupload_action', array( &$this, 'ep_plupload_action' ) );
    }

    function ep_metabox() {
        foreach( $this->_meta_box['page'] as $page ) {
            add_meta_box(
                $this->_meta_box['id'],
                $this->_meta_box['title'],
                array( &$this, 'show_metabox'),
                $page,
                $this->_meta_box['context'],
                $this->_meta_box['priority']
            );
        }
    }

    function ep_plupload_action() {
        $imgid = $_POST["imgid"];
        check_ajax_referer($imgid . 'pluploadan');
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

        $filename =$_FILES[$imgid . 'async-upload']['name'];
        $status = wp_handle_upload(
            $_FILES[$imgid . 'async-upload'],
            array(
                'test_form' => true,
                'action'    => 'plupload_action'
            )
        );
            if (!isset($status['file'])) { continue; }
            $file_name = $status['file'];
            $name_parts = pathinfo($file_name);
            $name = trim( substr( $filename, 0, -(1 + strlen($name_parts['extension'])) ) );
            $attachment = array(
                'post_mime_type' => $status['type'],
                'guid'           => $status['url'],
                'post_parent'    => $post_id,
                'post_title'     => $name,
                'post_content'   => '',
            );
            $id = wp_insert_attachment($attachment, $file_name, $post_id);
            if (!is_wp_error($id)) {
                wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $file_name));
                $new[] = $id;
            }

        $upload_path=wp_get_attachment_url($id, true);
            if(preg_match_all('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/',$upload_path,$matches)) {
                $image_attributes = wp_get_attachment_image_src( $id,'thumbnail');
                $uplaod_url=$image_attributes[0];
            } else {
                $uplaod_url=$upload_path;
            }
        $imagetest=array(
            'url'       =>  $status['url'],
            'link'      => get_edit_post_link($id),
            'audioid'   => $id,
            'name'      =>  $name,
            'img'       => $uplaod_url,
        );
        echo json_encode($imagetest);
        //print_r ($imagetest);
        exit;
    } // End ep_plupload_action()

    function ep_admin_enqueue() {
        wp_enqueue_script('plupload-all');
        wp_enqueue_script('atp_plupload',  THEME_URI . '/musicband/albums/multiupload.js', array( 'jquery-ui-sortable', 'wp-ajax-response', 'plupload-all' ));
        wp_enqueue_style('atp_plupload', THEME_URI . '/musicband/albums/multiupload.css');
    }

    function adminHead () {
        wp_enqueue_script( 'color-picker2', ATP_DIRECTORY.'/framework/admin/js/colorpicker.js', array('jquery') );
    }

    function plupload_admin_head() {
        global $post,$wpdb;
        if ( !$post )
            return;
        $post_id = $post->ID;

        // place js config array for plupload
        $plupload_init = array(
            'runtimes'              => 'html5,silverlight,flash,html4',
            'browse_button'         => 'plupload-browse-button',
            'container'             => 'plupload-upload-ui',
            'drop_element'          => 'drag-drop-area',
            'file_data_name'        => 'async-upload',
            'multiple_queues'       => true,
            'max_file_size'         => wp_max_upload_size(),
            'url'                   => admin_url('admin-ajax.php'),
            'flash_swf_url'         => includes_url('js/plupload/plupload.flash.swf'),
            'silverlight_xap_url'   => includes_url('js/plupload/plupload.silverlight.xap'),
            'multipart'             => true,
            'urlstream_upload'      => true,
             // additional post data to send to our ajax hook
            'multipart_params'      => array(
                '_ajax_nonce'       => "", // will be added per uploader
                'action'            => 'plupload_action', // the ajax action name
                'post_id' => $post_id
            )
        );
        ?>
        <script type="text/javascript">
            var base_plupload_config=<?php echo json_encode($plupload_init); ?>;
        </script>
        <?php
    } // End plupload_admin_head()

    /*
     * Callback function to show fields in meta box
    */
    function show_metabox() {
        global $page_layout, $post,$meta_box;
        // Defines custom sidebar widget based on custom option
        $sidebarwidget = get_option( 'atp_customsidebar' );

        // Use nonce for verification
        echo '<input type="hidden" name="page_page_layout_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

        // M E T A B O X   W R A P
        //--------------------------------------------------------
        echo '<div class="ep_meta_options">';
        foreach ( $this->_meta_box['fields'] as $field ) {
            // get current post meta data
            $meta = get_post_meta( $post->ID, $field['id'], true );

            if( $meta == "" ) {
                $meta = $field['std']; //Default Meta Array Value if empty
            }
            if( !isset($field['class']) ) {
                $field['class']='';
            }

            // M E T A B O X   O P T I O N S
            //--------------------------------------------------------
            echo '<div class="ep_options_box '.$field['class'].'"><div class="option-row">',
                 '<div class="ep_label"><label>', $field['name'], '</label></div>',
                 '<div class="ep_inputs">';
            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />';
                    break;

                case 'color':
                    ?>
                    <?php echo '<div class="meta_page_selectwrap"><input class="color"  name="'. $field['id'] .'" id="'. $field['id'] .'" type="text" value="', $meta ? $meta : $field['std'], '"  />';?>
                    <div id="<?php echo $field['id']; ?>_color" class="colorSelector"><div></div></div></div>
                    <?php
                    break;

                case 'textarea':
                    echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>';
                    break;

                case 'select':
                    echo '<div class="select_wrapper"><select class="select" name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $key => $value) {
                        echo '<option value="'.$key.'"', $meta == $key ? ' selected="selected"' : '', '>', $value, '</option>';
                    }
                    echo '</select></div>';
                    break;

                case 'multiselect':
                    echo '<div class="select_wrapper2">';
                     $count = count($field['options']);
                     if ( $count > 0 ){
                        echo '<select multiple="multiple"  name="', $field['id'], '[]" id="', $field['id'], '[]">';
                        foreach ( $field['options'] as $key => $value ) {
                            echo '<option value="'.$key.'"',  (is_array($meta) && in_array($key, $meta)) ? ' selected="selected"' : '', '>', $value, '</option>';
                        }
                        echo '</select>';
                    }else {
                        echo '<strong>No Posts IN Categories</strong>';
                    }
                    echo '</div>';
                    break;

                case 'customselect':
                    echo '<div class="select_wrapper"><select class="select" name="', $field['id'], '" id="', $field['id'], '">';
                    echo '<option value="">select</option>';
                    if( $sidebarwidget!="" ){
                        foreach ($field['options'] as $key => $value) {
                            echo '<option value="'.$value.'"', $meta == $value ? ' selected="selected"' : '', '>', $value, '</option>';
                        }
                    }
                    echo '</select></div>';
                    break;

                case 'newmeta':
                    $output = '<div id="custom_widget_sidebar"><table id="custom_widget_table" cellpadding="0" cellspacing="0">';
                    $output .='<tbody>';
                    if( $meta != "" ){
                        foreach( $meta as $custom_meta ) {
                            $output .= '<tr><td><input type="text" name="'.$field['id'].'[]" value="'. esc_attr($custom_meta).'"  size="30" style="width:97%" /></td><td><a class="button button-secondary" href="javascript:void(0);return false;" onClick="jQuery(this).parent().parent().remove();">Delete</a></td></tr>';
                        }
                    }
                    $output .= '</tbody></table><button type="button" class="button button-primary button-large" name="add_custom_widget" value="Add Meta" onClick="addWidgetRow()">Add Meta</button></div>';
                    ?>
                    <script type="text/javascript" language="javascript">
                    function addWidgetRow(){
                        jQuery('#custom_widget_table').append('<tr><td><input type="text" name="<?php echo $field['id'];?>[]" value="" size="30" style="width:97%" /></td><td><a class="button button-secondary" href="javascript:void(0);return false;" onClick="jQuery(this).parent().parent().remove();">Delete</a></td></tr>');
                    }
                    </script>
                    <?php
                    echo $output;
                    break;

                case 'timeslider':
                    $timeslider_options = array('meta'=>$meta,'field_id'=>$field['id']);
                    echo apply_filters('timeslider', $timeslider_options);
                    break;

                case 'map_location':
                    $maplocation_options = array('meta'=>$meta,'field_id'=>$field['id']);
                    echo apply_filters('map_location', $maplocation_options);
                    break;

                case 'add_buttons':
                    $button_options = array('meta'=>$meta,'field_id'=>$field['id']);
                    echo apply_filters('add_buttons', $button_options);
                    break;
                case 'external_mp3':
                    $button_options = array('meta'=>$meta,'field_id'=>$field['id']);
                    echo apply_filters('add_externalmp3', $button_options);
                    break;
                case 'radio':
                    $link_page='';  $link_cat=''; $link_post=''; $link_manually='';
                    foreach ($field['options'] as $key => $value) {
                        echo '<label class="rlabel"><input onclick="sys_custom_url_meta()" type="radio" name="', $field['id'], '" value="', $key, '"', $meta == $key ? ' checked="checked"' : '', ' />', $value,'</label>';
                    }
                    global $post;
                    $custom = get_post_custom($post->ID);
                    if(isset($custom['link_page'])){
                        $link_page = $custom["link_page"][0];
                    }
                    if(isset($custom['link_cat'])){
                        $link_cat = $custom["link_cat"][0];
                    }
                    if(isset($custom['link_post'])){
                        $link_post = $custom["link_post"][0];
                    }
                    if(isset($custom['link_manually'])){
                        $link_manually = stripslashes($custom["link_manually"][0]);
                    }
                    echo '<div id="customurl" >';
                    echo '<div id="sys_link" class="postlinkurl linkpage select_wrapper">';
                    echo '<select name="link_page" class="select">';
                    echo '<option value="">Select Page</option>';
                    foreach($this->get_custom_options('page') as $key => $option) {
                        echo '<option value="' . $key . '"';
                        if ( $key == $link_page ) {
                            echo ' selected="selected"';
                        }
                        echo '>' . $option . '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                    echo '<div id="sys_category" class="postlinkurl linktocategory">';
                    echo '<select name="link_cat">';
                    echo '<option value="">Select Category</option>';
                    foreach( $this->get_custom_options('cat') as $key => $option ) {
                        echo '<option value="' . $key . '"';
                        if ( $key == $link_cat ) {
                            echo ' selected="selected"';
                        }
                        echo '>' . $option . '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                    echo '<div id="sys_post" class="postlinkurl linktopost">';
                    echo '<select name="link_post">';
                    echo '<option value="">Select Post</option>';
                    foreach( $this->get_custom_options('post') as $key => $option ) {
                        echo '<option value="' . $key . '"';
                        if ( $key == $link_post ) {
                            echo ' selected="selected"';
                        }
                        echo '>' . $option . '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                    echo '<div id="sys_manually" class="postlinkurl linkmanually">';
                    if(isset($link_manually)){
                    echo'<input type="text" name="link_manually"  value="'.$link_manually.'"  size="50%" />';
                    }else{
                        echo'<input type="text" name="link_manually"  value=""  size="50%" />';
                    }
                    echo '</div></div>';
                    break;
                case 'upload':
                    echo'<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.stripslashes(get_post_meta($post->ID, $field['id'], true)).'" />';
                    echo'<input name="'.$field['id'].'" class="custom_upload_image_button button clearfix" type="button" value="Choose Image" />';
                    echo'<div id="atp_imagepreview-'.$field['id'].'" class="screenshot">';
                     if(get_post_meta($post->ID, $field['id'], true)) {
                         echo '<img src="'.stripslashes(get_post_meta($post->ID, $field['id'], true)).'" width="100" height="100" class="custom_preview_image" alt="" />';
                         echo '<a href="#" class="cimage_remove">Remove Image</a>';
                    }
                    echo '</div>';
                    break;

                case 'multiupload':
                    // adjust values here
                    $id = $field['id']; // this will be the name of form field. Image url(s) will be submitted in $_POST using this key. So if $id == “img1” then $_POST[“img1”] will have all the image urls
                    $multiimages = get_post_meta($post->ID,$id,true) ? get_post_meta($post->ID,$id,true) :'';
                    $svalue = $multiimages ? $multiimages :''; // this will be initial value of the above form field. Image urls.
                    $medialink = get_edit_post_link($post->ID);

                    if($field['multiple'] == 'true'){
                        $multiple = true; // allow multiple files upload
                    }else{
                        $multiple = false; // allow multiple files upload
                    }
                    $format=$field['format'] ? $field['format'] :'jpg,jpeg,gif,png';
                    $advance_meta='';
                    $img_id=array();
                    $img_url=array();
                    $img_title=array();
                    $media_value=array();
                    $img_path=array();
                    $img_path=array();
                    $media_value=explode(',',$svalue);
                    if($media_value){
                        foreach ($media_value as $attachment_id) {
                            $attachment = get_post( $attachment_id );
                            if(count($attachment) >0 ){
                                $file_path = get_attached_file($attachment->ID, true);
                                $upload_path=wp_get_attachment_url($attachment->ID, true);
                                if (file_exists($file_path)) {
                                    if(preg_match_all('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/',$upload_path,$matches)){
                                        $image_attributes = wp_get_attachment_image_src( $attachment->ID,'thumbnail' ); // returns an array
                                        $uplaod_url=$image_attributes[0];
                                    }else{
                                        $uplaod_url=$upload_path;
                                    }
                                    $img_url[] = get_edit_post_link( $attachment->ID );
                                    $img_title[]=$attachment->post_title;
                                    $img_path[]=$uplaod_url;
                                    $img_id[]=$attachment->ID;
                                }
                            }
                        }
                        $img_title= join(', ', $img_title);
                        $img_url= join(', ', $img_url);
                        $img_path= join(', ', $img_path);
                        $img_id= join(', ', $img_id);
                    }
                    $width = ''; // If you want to automatically resize all uploaded images then provide width here (in pixels)
                    $height = ''; // If you want to automatically resize all uploaded images then provide height here (in pixels)
                    ?>
                    <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>"  data-img="<?php echo $img_path; ?>" data-url="<?php echo $img_url; ?>" data-title="<?php echo $img_title; ?>"  value="<?php echo $img_id; ?>" />
                    <input type="hidden" class="format_filter"    value="<?php echo $format; ?>" />
                    <div class="plupload-upload-uic  hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
                        <input id="<?php echo $id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" />
                        <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
                        <?php if ($width && $height): ?>
                            <span class="plupload-resize"></span><span class="plupload-width" id="plupload-width<?php echo $width; ?>"></span>
                            <span class="plupload-height" id="plupload-height<?php echo $height; ?>"></span>
                        <?php endif; ?>
                        <div class="filelist"></div>
                    </div>
                    <ul class="iva-images iva-uploaded plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs"></li>
                    <div class="clear"></div>
                    <?php
                    break;

                case 'date':
                    echo'<script type="text/javascript">
                    /* <![CDATA[ */
                        jQuery(document).ready(function() {
                                jQuery("#'.$field['id'].'").datepicker({ dateFormat: "d-MM-yy" });
                    });
                    /* ]]> */
                    </script>';

                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />';
                    break;

                case 'dateformat':
                    global $default_date,$atp_defaultdate;
                    echo'<script type="text/javascript">
                    /* <![CDATA[ */
                        jQuery(document).ready(function() {
                                jQuery("#'.$field['id'].'").datepicker({ dateFormat: "'.$atp_defaultdate.'" });
                    });
                    /* ]]> */
                    </script>';
                    $eventdate = get_post_meta($post->ID, $field['id'], true);
                    if($eventdate !=''){
                        if(is_numeric($eventdate)){
                            $meta= date($default_date, get_post_meta($post->ID, $field['id'], true));
                        }else{
                            $meta=$eventdate;
                            $atp_defaultdate= 'd-MM-yy';
                        }
                    }
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />';
                    break;

                case 'layout':
                    $i = 0;
                    $select_value = $meta;
                    foreach ($field['options'] as $key => $value) {
                            $i++;
                        $checked = '';
                        $selected = '';
                        if($select_value != '') {
                            if ( $select_value == $key) { $checked = ' checked'; $selected = 'atp-radio-option-selected'; }
                            } else {
                                if ($meta == $key) { $checked = ' checked'; $selected = 'atp-radio-option-selected'; }
                                    elseif ($i == 1  && !isset($select_value)) { $checked = ' checked'; $selected = 'atp-radio-option-selected'; }
                                    elseif ($i == 1  && $meta == '') { $checked = ' checked'; $selected = 'atp-radio-option-selected'; }
                                else { $checked =  'checked'; }
                            }
                        echo '<input value="'.$key.'"  class="checkbox atp-radio-img-radio" type="radio" id="', $field['id'],$i,'" name="', $field['id'],'"'.$checked.' />';
                        echo '<img width="50" src="'.$value.'" alt="" class="atp-radio-option '. $selected .'" onClick="document.getElementById(\''. $field['id'].$i.'\').checked = true;" />';
                        }
                    break;

                case 'checkbox':
                    ( $meta != '' ) ? 'on':'off';
                    echo '<input  type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta == 'on' ? ' checked="checked"' : '', ' /><label for="', $field['id'], '">',$field['desc'],'</label>';
                    break;
            }
            if($field['type'] != 'checkbox') {
                echo '<p class="desc">',$field['desc'],'</p>';
            }
            echo '</div><div class="clear"></div>';
            echo '</div></div>';
        } // End foreach
        echo '</div>';
    }
    // E N D  - SHOW METABOX

    // S A V E   M E T A   D A T A
    //--------------------------------------------------------
    function savemeta($post_id,$post) {
        if ( !isset( $_POST['page_page_layout_nonce'] ) || !wp_verify_nonce( $_POST['page_page_layout_nonce'], basename( __FILE__ ) ) ) {
            return $post_id;
        }

        // Get the post type object.
        $post_type = get_post_type_object( $post->post_type );

        // Check if the current user has permission to edit the post
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
            return $post_id;

        // Is the user allowed to edit the post or page?
        foreach ( $this->_meta_box['fields'] as $field ) {
            if( $field['type'] == 'map_location' ) {
                $map = get_post_meta( $post_id, $field['id'], true );
                $new_map = isset( $_POST[$field['id']] )? $_POST[$field['id']]:'';
                if ( $new_map && $new_map != $map ) {
                    $controller = (isset($new_map['controller']) == 'on') ? 'on': 'off';
                    $string = $new_map['longitutes'] . ','. $new_map['latitudes'].',' . $new_map['zoom']. ','.$controller;
                    update_post_meta( $post_id, $field['id'], $string );
                } elseif ( '' == $new_map && $map ) {
                    delete_post_meta($post_id, $field['id'], $map);
                }
            }

            if( $field['type'] =='timeslider' ) {
                $old = get_post_meta( $post_id, $field['id'], true );
                $new = isset( $_POST[$field['id']] )? $_POST[$field['id']]:'';
                if ( $new && $new != $old ) {
                    $alldays= (isset($new['alldays']) == 'on') ? 'on': 'off';
                    $string = $new['starttime'] . ',' . $new['endtime'].' ,' .$alldays;
                    update_post_meta( $post_id, $field['id'], $string );
                } elseif ( '' == $new && $old ) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            }

            if( $field['type'] == 'add_buttons' ) {
                $data = array();
                $audio_btn = array();
                $audio_btn = isset($_POST[$field['id'] . '_buttonname']) ? $_POST[$field['id'] . '_buttonname']:'';
                if(!empty($audio_btn)) {
                    foreach ( $audio_btn as $key => $value ) {
                        if(!empty($value)) {
                            $data[] = array(
                                'buttonname' => $value,
                                'buttonurl' => $_POST[$field['id'] . '_buttonurl'][$key],
                                'buttoncolor' => $_POST[$field['id'] . '_buttoncolor'][$key],
                            );
                        }
                    }
                }
                if ( get_post_meta($post_id, $field['id']) == "" ){
                    add_post_meta($post_id, $field['id'], $data, true);
                } elseif ( $data != get_post_meta( $post_id, $field['id'], true ) ) {
                    update_post_meta($post_id, $field['id'], $data);
                }
            } elseif( $field['type'] == 'external_mp3' ) {
                $data = array();
                $mp3url_btn = array();
                $mp3url_btn = isset($_POST[$field['id'] . '_mp3url']) ? $_POST[$field['id'] . '_mp3url']:'';
                if(!empty($mp3url_btn)) {
                    foreach ( $mp3url_btn as $key => $value ) {
                        if(!empty($value)) {
                            $data[] = array(
                                'mp3url' => $value,
                                'mp3title' => $_POST[$field['id'] . '_mp3title'][$key],
                                'download' => $_POST[$field['id'] . '_download'][$key],
                                'buylink' => $_POST[$field['id'] . '_buylink'][$key],
                                'lyrics' => $_POST[$field['id'] . '_lyrics'][$key],
                            );
                        }
                    }
                }
                if ( get_post_meta($post_id, $field['id']) == "" ){
                    add_post_meta($post_id, $field['id'], $data, true);
                } elseif ( $data != get_post_meta( $post_id, $field['id'], true ) ) {
                    update_post_meta($post_id, $field['id'], $data);
                }
            } else {
                $old = get_post_meta( $post_id, $field['id'], true );
                $new = isset( $_POST[$field['id']] )? $_POST[$field['id']]:'';
                if ($field['type'] == 'dateformat') {
                    global $default_date;
                    if($default_date == 'd/m/Y' ){
                        $new = str_replace('/', '-', $new);
                    }

                    $new = strtotime($new);
                }
                if ( $new && $new != $old ) {
                    update_post_meta( $post_id, $field['id'], $new );
                } elseif ( '' == $new && $old ) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            }
        } // End foreach
    } // savemeta()

    // function get_custom_options - fetch pages/posts/cats
    //--------------------------------------------------------
    function get_custom_options($type) {
        switch ($type) {
            case 'page':
                $entries = get_pages('title_li=&orderby=name');
                foreach ($entries as $key => $entry) {
                    $options[$entry->ID] = $entry->post_title;
                }
                break;
            case 'cat':
                $entries = get_categories('title_li=&orderby=name&hide_empty=0');
                foreach ($entries as $key => $entry) {
                    $options[$entry->term_id] = $entry->name;
                }
                break;
            case 'post':
                $entries = get_posts('orderby=title&numberposts=-1&order=ASC');
                foreach ($entries as $key => $entry) {
                    $options[$entry->ID] = $entry->post_title;
                }
                break;
            default:
                $options = false;
        }
        return $options;
    }
} // End class EP_Custom_Fields()

foreach($this->meta_box as $box){
    $customfields = new EP_Custom_Fields($box);
}
