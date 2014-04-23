<?php
/*
  Plugin Name: Google Map Targeting
  Plugin URI: http://pluginus.net/gmap-targeting/
  Description: Set Google Map everywhere on your by shortcode site simply. One click - one map
  Author: Rostislav Sofronov <realmag777>
  Version: 1.1.2
  Author URI: http://pluginus.net/
 */

//23-04-2014
class PluginusNet_GMapTargeting {

    public static $shortcodes = array();
    public static $shortcode_is_done = false;

    //*****************************

    public static function get_application_path() {
        return plugin_dir_path(__FILE__);
    }

    public static function get_application_uri() {
        return plugin_dir_url(__FILE__);
    }

    public static function init() {
        load_plugin_textdomain('gmap-targeting', false, dirname(plugin_basename(__FILE__)) . '/languages');
        //***
        add_action('wp_head', array(__CLASS__, 'wp_head'), 1);
        add_action('admin_head', array(__CLASS__, 'admin_head'), 1);
        //***

        register_widget('PluginusNet_GmapTargetingWidget');

        //AJAX callbacks
        add_action('wp_ajax_gmap_targeting_get_shortcode_template', array(__CLASS__, 'get_shortcode_template'));

        //***
        $shortcodes = self::get_shortcodes_array();
        if(!empty($shortcodes)) {
            foreach($shortcodes as $value) {
                $name = ucfirst(trim($value));
                $name = str_replace("_", " ", $name);
                self::$shortcodes[$value] = $name;
            }
        }
        //*****
        $shortcodes_keys = array_keys(self::$shortcodes);
        foreach($shortcodes_keys as $shortcode_key) {
            $_REQUEST["shortcode_key"] = $shortcode_key;
            add_shortcode($shortcode_key, array(__CLASS__, 'shortcode_do'));
        }
    }

    public static function shortcode_do( $attributes = array(), $content = "", $shortcode_key ) {
        $attributes["content"] = $content;
        return PluginusNet_GMapTargeting::draw_html($shortcode_key, $attributes);
    }

    public static function wp_head() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('maps.google.com', 'http://maps.google.com/maps/api/js?sensor=false');
        ?>
        <style type="text/css">
            .google_map div img {max-width:none !important;}
        </style>
        <?php
    }

    public static function admin_head() {
        add_filter('mce_buttons', array(__CLASS__, 'mce_buttons'));
        add_filter('mce_external_plugins', array(__CLASS__, 'mce_add_rich_plugins'));

        //global $pagenow;
        $show_shortcode = substr_count($_SERVER['PHP_SELF'], '/wp-admin/post.php');
        if(!$show_shortcode) {
            $show_shortcode = substr_count($_SERVER['PHP_SELF'], '/wp-admin/post-new.php');
        }
        if($show_shortcode):
            wp_enqueue_script('pn_ext_shortcodes3', self::get_application_uri() . 'js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-sortable'));
            wp_enqueue_style('pn_ext_shortcodes3', self::get_application_uri() . 'css/admin.css');
            wp_enqueue_style('pn_ext_shortcodes31', self::get_application_uri() . 'css/shortcodes.css');
            ?>
            <script type="text/javascript">
                var pn_gmt_plugin_url = "<?php echo PluginusNet_GMapTargeting::get_application_uri() ?>";
                var pn_lang_loading = "<?php _e('Loading ...', 'gmap-targeting'); ?>";
            <?php
            wp_enqueue_script('pn_ext_shortcodes3_popup_js', self::get_application_uri() . 'js/pn_popup/pn_advanced_wp_popup.js', array('jquery', 'jquery-ui-core', 'jquery-ui-draggable'));
            wp_enqueue_style('pn_ext_shortcodes3_popup_css', self::get_application_uri() . 'js/pn_popup/styles.css');
            ?>


                var gmt_lang_insert = "<?php _e('Insert Google Map', 'gmap-targeting') ?>";
                var gmt_lang_popup_title = "<?php _e('Google Map by www.pluginus.net', 'gmap-targeting') ?>";
                var gmt_lang_made_by = "<?php _e('Google Map by www.pluginus.net', 'gmap-targeting') ?>";
                var gmt_lang_apply = "<?php _e('Apply', 'gmap-targeting') ?>";
                var gmt_lang_close = "<?php _e('Close', 'gmap-targeting') ?>";
            </script>

            <style type="text/css">
                i.gmap_targeting_icon{
                    background-image: url('<?php echo self::get_application_uri() ?>images/shortcode_icon.png');   
                }
            </style>

            <?php
        endif;
    }

    /*     * ***************************** */

    public static function draw_html( $shortcode_key, $attributes = array() ) {
        return self::render_html("views/shortcodes/gmap_targeting.php", $attributes);
    }

    public static function get_shortcodes_array() {
        return array('gmap_targeting');
    }

    //*****************************


    public static function mce_buttons( $buttons ) {
        array_push($buttons, "gmap_targeting");
        return $buttons;
    }

    public static function mce_add_rich_plugins( $plugin_array ) {
        global $wp_version;
        if($wp_version >= 3.9) {
            $plugin_array['pn_tiny_gmap_targeting'] = self::get_application_uri() . '/js/editor.js';
        } else {
            $plugin_array['pn_tiny_gmap_targeting'] = self::get_application_uri() . '/js/wp38/editor.js';
        }
        return $plugin_array;
    }

    //ajax
    public static function get_shortcode_template() {
        $data = array();
        if($_REQUEST['mode'] == 'edit') {
            $_REQUEST['shortcode_mode_edit'] = array();
            $_REQUEST['shortcode_text'] = str_replace("\'", "'", $_REQUEST['shortcode_text']);
            $_REQUEST['shortcode_text'] = str_replace('\"', '"', $_REQUEST['shortcode_text']);
            do_shortcode($_REQUEST['shortcode_text']);
        }
        //***
        wp_die(self::render_html('views/shortcodes/popups/gmap_targeting.php', $data));
    }

    //for inputs in shortcode popups
    public static function set_default_value( $key, $default_value = '' ) {
        if(isset($_REQUEST["shortcode_mode_edit"]) AND ! empty($_REQUEST["shortcode_mode_edit"])) {
            if(is_array($_REQUEST["shortcode_mode_edit"])) {
                if(isset($_REQUEST["shortcode_mode_edit"][$key])) {
                    return $_REQUEST["shortcode_mode_edit"][$key];
                }
            }
        }

        return $default_value;
    }

    public static function render_html( $pagepath, $data = array() ) {
        $pagepath = self::get_application_path() . '/' . $pagepath;
        @extract($data);
        ob_start();
        include($pagepath);
        return ob_get_clean();
    }

    public static function draw_shortcode_option( $data ) {
        switch($data['type']) {
            case 'textarea':
                ?>
                <?php if(!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <textarea id="<?php echo $data['id'] ?>" class="js_shortcode_template_changer data-area" data-shortcode-field="<?php echo $data['shortcode_field'] ?>"><?php echo $data['default_value'] ?></textarea>
                <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php
                break;
            case 'select':
                if(!isset($data['display'])) {
                    $data['display'] = 1;
                }
                ?>
                <?php if(!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <?php if(!empty($data['options'])): ?>
                    <select <?php if($data['display'] == 0): ?>style="display: none;"<?php endif; ?> class="js_shortcode_template_changer data-select <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" id="<?php echo $data['id'] ?>">

                        <?php foreach($data['options'] as $key=> $text) : ?>
                            <option <?php if($data['default_value'] == $key) echo 'selected' ?> value="<?php echo $key ?>"><?php echo $text ?></option>
                        <?php endforeach; ?>

                    </select>
                    <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php endif; ?>
                <?php
                break;
            case 'text':
                ?>
                <?php if(!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <input type="text" value="<?php echo $data['default_value'] ?>" <?php if(isset($data['placeholder'])): ?>placeholder="<?php echo $data['placeholder'] ?>"<?php endif; ?> class="js_shortcode_template_changer data-input <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" id="<?php echo $data['id'] ?>" />
                <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php
                break;
            case 'color':
                ?>
                <div <?php if(@$data['display'] == 0): ?>style="display: none;"<?php endif; ?> class="list-item-color">
                    <?php if(!empty($data['title'])): ?>
                        <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                    <?php endif; ?>

                    <input type="text" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" value="<?php echo $data['default_value'] ?>" class="bg_hex_color text small js_shortcode_template_changer <?php echo @$data['css_classes']; ?>" id="<?php echo $data['id'] ?>">
                    <div style="background-color: <?php echo $data['default_value'] ?>" class="bgpicker"></div>
                    <span class="preset_description"><?php echo $data['description'] ?></span>
                </div>
                <?php
                break;
            case 'upload':
                ?>
                <?php if(!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <input type="text" id="<?php echo $data['id'] ?>" value="<?php echo $data['default_value'] ?>" class="js_shortcode_template_changer data-input data-upload <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" />
                <a title="" class="pn_button_upload3 button-primary" href="#">
                    <?php _e('Upload', 'gmap-targeting'); ?>
                </a>
                <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php
                break;
            case 'checkbox':
                ?>
                <div class="radio-holder">
                    <input <?php if($data['is_checked']): ?>checked=""<?php endif; ?> type="checkbox" value="<?php if($data['is_checked']): ?>1<?php else: ?>0<?php endif; ?>" id="<?php echo $data['id'] ?>" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="<?php echo $data['shortcode_field'] ?>">
                    <label for="<?php echo $data['id'] ?>"><span></span><i class="description"><?php if(!empty($data['title'])): ?><?php echo $data['title'] ?><?php endif; ?></i></label>
                </div><!--/ .radio-holder-->
                <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php
                break;
            case 'radio':
                ?>
                <?php if(!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <div class="radio-holder">
                    <input <?php if($data['values'][0]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo $data['name'] ?>" id="<?php echo $data['values'][0]['id'] ?>" value="<?php echo $data['values'][0]['value'] ?>" class="js_shortcode_radio_self_update" />
                    <label for="<?php echo $data['values'][0]['id'] ?>" class="label-form"><span></span><?php echo $data['values'][0]['title'] ?></label>

                    <input <?php if($data['values'][1]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo $data['name'] ?>" id="<?php echo $data['values'][1]['id'] ?>" value="<?php echo $data['values'][1]['value'] ?>" class="js_shortcode_radio_self_update" />
                    <label for="<?php echo $data['values'][1]['id'] ?>" class="label-form"><span></span><?php echo $data['values'][1]['title'] ?></label>

                    <input type="hidden" id="<?php echo @$data['hidden_id'] ?>" value="<?php echo $data['value'] ?>" class="js_shortcode_template_changer" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" />
                </div><!--/ .radio-holder-->
                <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php
                break;
        }
    }

    public static function draw_adv_meta() {
        //http://codecanyon.net/user/realmag777/portfolio?WT.ac=item_portfolio&WT.seg_1=item_portfolio&WT.z_author=realmag777&ref=realmag777
    }

    public static function draw_donate_button() {
        ?>
        <a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=rostislavsofronov%40gmail%2ecom&lc=US&item_name=PluginusNet&item_number=4&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted" class="button-primary" style="font-size: 16px;"><?php _e('Donate for GMap Targeting', "gmap-targeting") ?></a><br />
        <?php
    }

}

class PluginusNet_GmapTargetingWidget extends WP_Widget {

    //Widget Setup
    function __construct() {
        //Basic settings
        $settings = array('classname'=>__CLASS__, 'description'=>__('Google Map Widget', 'gmap-targeting'));

        //Creation
        $this->WP_Widget(__CLASS__, __('Google Map by www.pluginus.net', 'gmap-targeting'), $settings);
    }

    //Widget view
    function widget( $args, $instance ) {
        $args['instance'] = $instance;
        echo PluginusNet_GMapTargeting::render_html('views/widget/google_map.php', $args);
    }

    //Update widget
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['width'] = $new_instance['width'];
        $instance['height'] = $new_instance['height'];
        $instance['mode'] = $new_instance['mode'];
        $instance['latitude'] = $new_instance['latitude'];
        $instance['longitude'] = $new_instance['longitude'];
        $instance['address'] = $new_instance['address'];
        $instance['location_mode'] = $new_instance['location_mode'];
        $instance['zoom'] = $new_instance['zoom'];
        $instance['scrollwheel'] = $new_instance['scrollwheel'];
        $instance['maptype'] = $new_instance['maptype'];
        $instance['marker'] = $new_instance['marker'];
        $instance['popup'] = $new_instance['popup'];
        $instance['popup_text'] = $new_instance['popup_text'];
        return $instance;
    }

    //Widget form
    function form( $instance ) {
        //Defaults
        $defaults = array(
            'title'=>'Our Location',
            'width'=>'200',
            'height'=>'200',
            'mode'=>'image',
            'latitude'=>"40.714623",
            'longitude'=>"-74.006605",
            'address'=>'New York',
            'location_mode'=>'address',
            'zoom'=>12,
            'maptype'=>'ROADMAP',
            'marker'=>'false',
            'scrollwheel'=>'false',
            'popup'=>'false',
            'popup_text'=>""
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $args = array();
        $args['instance'] = $instance;
        $args['widget'] = $this;
        echo PluginusNet_GMapTargeting::render_html('views/widget/google_map_form.php', $args);
    }

}

//*******

add_action('init', array('PluginusNet_GMapTargeting', 'init'), 1);

