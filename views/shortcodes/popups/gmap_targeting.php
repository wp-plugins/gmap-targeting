<?php if(!defined('ABSPATH')) die('No direct access allowed'); ?>

<div id="pn_shortcode_template3" class="pn_shortcode_template3 clearfix">

    <div class="one-half">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'text',
            'title'=>__('Height', 'gmap-targeting'),
            'shortcode_field'=>'height',
            'id'=>'height',
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('height', 500),
            'description'=>''
        ));
        ?>

    </div><!--/ .one-half-->


    <div class="one-half">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'text',
            'title'=>__('Width', 'gmap-targeting'),
            'shortcode_field'=>'width',
            'id'=>'width',
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('width', 500),
            'description'=>__('If map mode, you can set in %. Ex.: 100%', 'gmap-targeting'),
        ));
        ?>
    </div><!--/ .one-half-->


    <div class="one-half">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'select',
            'title'=>__('Mode', 'gmap-targeting'),
            'shortcode_field'=>'mode',
            'id'=>'map_mode',
            'options'=>array(
                'map'=>__('Map', 'gmap-targeting'),
                'image'=>__('Image', 'gmap-targeting'),
            ),
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('mode', 'map'),
            'description'=>''
        ));
        ?>
    </div><!--/ .one-half-->


    <div class="one-half">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'select',
            'title'=>__('Location mode', 'gmap-targeting'),
            'shortcode_field'=>'location_mode',
            'id'=>'location_mode',
            'options'=>array(
                'address'=>__('Address', 'gmap-targeting'),
                'coordinates'=>__('Coordinates', 'gmap-targeting'),
            ),
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('location_mode', 'address'),
            'description'=>''
        ));
        ?>
    </div><!--/ .one-half-->



    <div class="one-half location_mode_coordinates location_mode_container" style="display: none;">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'text',
            'title'=>__('Marker Latitude', 'gmap-targeting'),
            'shortcode_field'=>'latitude',
            'id'=>'latitude',
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('latitude', 40.714623),
            'description'=>__('Point on which the viewport will be centered.', 'gmap-targeting')
        ));
        ?>		

    </div><!--/ .one-half-->


    <div class="one-half location_mode_coordinates location_mode_container" style="display: none;">

        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'text',
            'title'=>__('Marker Longitude', 'gmap-targeting'),
            'shortcode_field'=>'longitude',
            'id'=>'longitude',
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('longitude', -74.006605),
            'description'=>__('Point on which the viewport will be centered.', 'gmap-targeting')
        ));
        ?>
    </div><!--/ .one-half-->


    <div class="one-half location_mode_address location_mode_container">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'text',
            'title'=>__('Address', 'gmap-targeting'),
            'shortcode_field'=>'address',
            'id'=>'address',
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('address', 'New York'),
            'description'=>''
        ));
        ?>
    </div><!--/ .one-half-->


    <div class="one-half">
        <?php
        $zoom_array = array();
        for($i = 1; $i <= 19; $i++) {
            $zoom_array[$i] = $i;
        }
        ?>

        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'select',
            'title'=>__('Zoom', 'gmap-targeting'),
            'shortcode_field'=>'zoom',
            'id'=>'zoom',
            'options'=>$zoom_array,
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('zoom', 11),
            'description'=>__('Zoom value from 1 to 19 where 19 is the greatest and 1 the smallest.', 'gmap-targeting')
        ));
        ?>

    </div><!--/ .one-half-->


    <div class="one-half">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'select',
            'title'=>__('Maptype', 'gmap-targeting'),
            'shortcode_field'=>'maptype',
            'id'=>'maptype',
            'options'=>array(
                'ROADMAP'=>__('ROADMAP', 'gmap-targeting'),
                'SATELLITE'=>__('SATELLITE', 'gmap-targeting'),
                'HYBRID'=>__('HYBRID', 'gmap-targeting'),
                'TERRAIN'=>__('TERRAIN', 'gmap-targeting'),
            ),
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('maptype', 'ROADMAP'),
            'description'=>''
        ));
        ?>	
    </div><!--/ .one-half-->



    <div class="one-half">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'checkbox',
            'title'=>__('Enable Marker', 'gmap-targeting'),
            'shortcode_field'=>'enable_marker',
            'id'=>'enable_marker',
            'is_checked'=>PluginusNet_GMapTargeting::set_default_value('enable_marker', 0),
            'description'=>__('Set to false to disable display a marker in the viewport.', 'gmap-targeting')
        ));
        ?>
    </div><!--/ .one-half-->


    <div class="one-half pn_gmt_type_map" id="enable_scrollwheel_container" style="display: none;">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'checkbox',
            'title'=>__('Enable Scrollwheel', 'gmap-targeting'),
            'shortcode_field'=>'enable_scrollwheel',
            'id'=>'enable_scrollwheel',
            'is_checked'=>PluginusNet_GMapTargeting::set_default_value('enable_scrollwheel', 0),
            'description'=>__('Set to false to disable zooming with your mouses scrollwheel.', 'gmap-targeting')
        ));
        ?>
    </div><!--/ .one-half-->

    <div class="one-half pn_gmt_type_map" id="marker_is_draggable_container" style="display: none;">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'checkbox',
            'title'=>__('Marker is draggable', 'gmap-targeting'),
            'shortcode_field'=>'marker_is_draggable',
            'id'=>'marker_is_draggable',
            'is_checked'=>PluginusNet_GMapTargeting::set_default_value('marker_is_draggable', 0),
            'description'=>__('Set marker draggable', 'gmap-targeting')
        ));
        ?>		
    </div><!--/ .one-half-->

    <div class="one-half pn_gmt_type_map" id="enable_popup_container" style="display: none;">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'checkbox',
            'title'=>__('Enable Popup', 'gmap-targeting'),
            'shortcode_field'=>'enable_popup',
            'id'=>'enable_popup',
            'is_checked'=>PluginusNet_GMapTargeting::set_default_value('enable_popup', 0),
            'description'=>__('If true the info window for this marker will be shown when the map finished loading. If html is empty this option will be ignored.', 'gmap-targeting')
        ));
        ?>

    </div><!--/ .one-half-->


    <div class="fullwidth pn_gmt_type_map" id="pn_gmt_popup_container" style="display: none;">
        <?php
        PluginusNet_GMapTargeting::draw_shortcode_option(array(
            'type'=>'textarea',
            'title'=>__('Popup Content', 'gmap-targeting'),
            'shortcode_field'=>'content',
            'id'=>'',
            'default_value'=>PluginusNet_GMapTargeting::set_default_value('content', ''),
            'description'=>''
        ));
        ?>
    </div><!--/ .one-half-->

    <br />

</div>

<!-- --------------------------  PROCESSOR  --------------------------- -->
<script type="text/javascript">
    var shortcode_name = "<?php echo basename(__FILE__, '.php'); ?>";
    jQuery(function() {

        jQuery('#map_mode').change(function() {
            if (this.value == 'map') {
                jQuery('.pn_gmt_type_map').show(150);
            } else {
                jQuery('.pn_gmt_type_map').hide(150);
            }
        });

        jQuery('#location_mode').change(function() {
            jQuery('.location_mode_container').hide();
            if (this.value == 'address') {
                jQuery('.location_mode_address').show(150);
            } else {
                jQuery('.location_mode_coordinates').show(150);
            }
        });
        jQuery("#enable_popup").life('click', function() {
            if (jQuery(this).is(":checked")) {
                jQuery('#pn_gmt_popup_container').show(200);
            } else {
                jQuery('#pn_gmt_popup_container').hide(200);
            }
        });


        jQuery("#enable_marker").life('click', function() {
            if (jQuery('#map_mode').val() == 'map') {
                if (jQuery(this).is(":checked")) {
                    jQuery('#enable_popup_container').show(200);
                    jQuery('#marker_is_draggable_container').show(200);
                    jQuery('#enable_scrollwheel_container').show(200);
                } else {
                    jQuery('#enable_popup_container').hide(200);
                    jQuery('#marker_is_draggable_container').hide(200);
                    jQuery('#enable_scrollwheel_container').hide(200);
                    if (jQuery('#pn_gmt_popup_container').is(":visible")) {
                        jQuery("#enable_popup").trigger('click');
                    }
                }
            }
        });

        pn_ext_shortcodes3.changer(shortcode_name);
        jQuery("#pn_shortcode_template3 .js_shortcode_template_changer").on('keyup change', function() {
            pn_ext_shortcodes3.changer(shortcode_name);
        });
    });
</script>
