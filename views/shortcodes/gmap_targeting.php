<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php $inique_id = uniqid(); ?>
<?php
if ($mode == 'map') {
    wp_enqueue_script('pn_theme_markerwithlabel_js', PluginusNet_GMapTargeting::get_application_uri() . '/js/shortcodes/markerwithlabel.js', array('jquery'));
    wp_enqueue_script('pn_shortcode_google_map_js', PluginusNet_GMapTargeting::get_application_uri() . '/js/shortcodes/google_map.js', array('jquery'));
}
$js_controls = '{}';
//***
if (isset($location_mode)) {
    if ($location_mode == 'address') {
        $address = str_replace(' ', '+', $address);
        $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false');
        $output = json_decode($geocode);
        if (isset($output->status) AND $output->status != 'OVER_QUERY_LIMIT') {
            $latitude = $output->results[0]->geometry->location->lat;
            $longitude = $output->results[0]->geometry->location->lng;
        } else {
            $mode = 'image';
        }
    }
}
?>

<?php if ($mode == 'map'): ?>

    <div class="google_map" id="google_map_<?php echo $inique_id ?>" style="height: <?php echo $height ?>px;"></div>

    <script type="text/javascript">
        jQuery(function() {
            pn_gmt_init_map(<?php echo $latitude ?>,<?php echo $longitude ?>, "google_map_<?php echo $inique_id ?>", <?php echo $zoom ?>, "<?php echo $maptype ?>", "<?php echo $content ?>", "<?php echo $enable_marker ?>", "<?php echo $enable_popup ?>", "<?php echo $enable_scrollwheel ?>",<?php echo $js_controls ?>, "<?php echo @$marker_is_draggable ?>");
        });
    </script>
<?php else: ?>
    <?php
    $marker_string = '';
    if ($enable_marker) {
        $marker_string = '&markers=color:red|label:P|' . $latitude . ',' . $longitude;
    }

    $location_mode_string = 'center=' . $latitude . ',' . $longitude;
    ?>

    <img src="http://maps.googleapis.com/maps/api/staticmap?<?php echo $location_mode_string ?>&zoom=<?php echo $zoom ?>&maptype=<?php echo strtolower($maptype) ?>&size=<?php echo str_replace('%', '', $width) ?>x<?php echo str_replace('%', '', $height) ?><?php echo $marker_string ?>&sensor=false">

<?php endif;

