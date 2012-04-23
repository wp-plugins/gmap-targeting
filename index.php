<?php

/*
  Plugin Name: Gmap Targeting
  Plugin URI: http://pluginus.net/gmap-targeting/
  Description: Gmap your page
  Author: Rostislav Sofronov
  Version: 1.0.3
  Author URI: http://pluginus.net/
 */


### Load WP-Config File If This File Is Called Directly
if (!function_exists('add_action')) {
    $wp_root = '../../..';
    if (file_exists($wp_root . '/wp-load.php')) {
        require_once($wp_root . '/wp-load.php');
    } else {
        require_once($wp_root . '/wp-config.php');
    }
}

/* GLOBAL SETTINGS */

define("GMT_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("GMT_PLUGIN_LINK", plugin_dir_url(__FILE__));

include_once 'helper.php';
include_once 'classes/controller.php';
if (file_exists(GMT_PLUGIN_PATH . 'localization/' . WPLANG . '.php')) {
    include_once GMT_PLUGIN_PATH . 'localization/' . WPLANG . '.php';
} else {
    include_once GMT_PLUGIN_PATH . 'localization/en_EN.php';
}


header("Content-Type: content=text/html; charset=utf-8");
//******************** ADMIN AJAX *************************************/
if (isset($_REQUEST['gmt_admin_ajax_action'])) {
    $controller = new GMT_Controller();
    $wp_user_level = get_user_meta(get_current_user_id(), 'wp_user_level');
    $wp_user_level = $wp_user_level[0];

    switch ($_REQUEST['gmt_admin_ajax_action']) {
        case 'ex':
            if ($wp_user_level == 10) {
                
            }
            break;


        default:
            break;
    }
    exit;
}
//******************** ADMIN AJAX END *************************************/

register_activation_hook(__FILE__, 'gmt_setup');
register_uninstall_hook(__FILE__, 'gmt_uninstall');

function gmt_setup() {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $sql_install = @file_get_contents(GMT_PLUGIN_PATH . 'install/gmap_targeting_coordinates.sql');
    @dbDelta($sql_install);
    $sql_install = @file_get_contents(GMT_PLUGIN_PATH . 'install/gmap_targeting_map_info.sql');
    @dbDelta($sql_install);
}

function gmt_uninstall() {
    global $wpdb;
    $sql = ("DROP TABLE `gmap_targeting_coordinates`,`gmap_targeting_map_info`");
    $wpdb->query($sql);
}

//*********************************************
/* Add page head */
add_action('admin_head', 'gmt_admin_head');
add_action('wp_head', 'gmt_front_head');

function gmt_admin_head() {
    wp_enqueue_style("gmt", GMT_PLUGIN_LINK . "css/gmt.css");
    echo '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>';
    wp_enqueue_script('gmt_markerwithlabel', plugins_url('js/markerwithlabel.js', __FILE__), array('jquery'), '1.0');
    wp_enqueue_script('gmt_admin', plugins_url('js/admin.js', __FILE__), array('jquery'), '1.0');
    include_once 'js/front_js.php';
}

function gmt_front_head() {
    //wp_enqueue_script('jquery');
    echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
    echo '<script type="text/javascript">google.load("jquery", "1.7.1");</script>';
    echo '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>';
    wp_enqueue_script('gmt_markerwithlabel', plugins_url('js/markerwithlabel.js', __FILE__), array('jquery'), '1.0');
    wp_enqueue_script('gmt', plugins_url('js/gmt.js', __FILE__), array('jquery'), '1.0');
    wp_enqueue_style("gmt", GMT_PLUGIN_LINK . "css/gmt.css");
    include_once 'js/front_js.php';
}

add_action('admin_menu', 'gmt_menu');

function gmt_menu() {


    add_meta_box('gmap-targeting_plugin', gmt_helper_localize('Google Map Targeting'), 'gmt_draw_post_panel', 'post');
    add_meta_box('gmap-targeting_plugin', gmt_helper_localize('Google Map Targeting'), 'gmt_draw_post_panel', 'page');


    /*
      if (function_exists('add_menu_page')) {
      add_menu_page('Mealingua', 'Mealingua', 'edit_pages', 'mealingua' . '/page.php', '', '');
      }
      add_submenu_page('mealingua/page.php', "Settings", gmt_helper_localize('settings'), 'edit_pages', "admin.php?page=mealingua/page.php&action=settings");
      add_submenu_page('mealingua/page.php', "Languages", gmt_helper_localize('languages'), 'edit_pages', "admin.php?page=mealingua/page.php&action=languages");
     */
}

function gmt_draw_post_panel() {

    $controller = new GMT_Controller();
    $post_id = 0;
    if (isset($_GET['post'])) {
        $post_id = (int) $_GET['post'];
    }
    $controller->draw_post_panel($post_id);
}

/*
 * here hook to page "publish_post" - for post/page
 */

add_action('publish_page', 'gmt_save_data', 10);
add_action('publish_post', 'gmt_save_data', 10);

function gmt_save_data() {
    if (!empty($_POST)) {
        if (isset($_POST['gmt_data'])) {
            $controller = new GMT_Controller();
            $controller->model->save_post_data($_POST);
        }
    }
}

add_shortcode('gmap_targeting', 'gmap_targeting_shortcode');

function gmap_targeting_shortcode($attributes) {
    if (!class_exists("GMT_Controller")) {
        include_once GMT_PLUGIN_PATH . 'classes/controller.php';
    }
    $controller = new GMT_Controller();
    return $controller->gmt_map_shortcode($attributes);
}
