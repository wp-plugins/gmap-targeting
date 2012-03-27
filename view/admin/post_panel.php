<table style="width: 100%;">
  <tr>
	<td colspan="2">
	  <input style="width: 100%;" type="text" readonly="" name="gmt_shortcode" id="" value="[gmap_targeting post_id=<?= $_GET['post'] ?>]" /><br />
	</td>
  </tr>
  <tr>
	<td style="width: 70%; vertical-align: top;">
	  <?php if (empty($gmtdata['info'])): ?>
  	  <textarea onkeyup="gmt_tooltip_change(this.value)" name="gmt_info" style="width: 100%; height: 150px;"></textarea><br />
	  <?php else: ?>
  	  <textarea onkeyup="gmt_tooltip_change(this.value)" name="gmt_info" style="width: 100%; height: 150px;"><?= $gmtdata["info"] ?></textarea><br />
	  <?php endif; ?>
	</td>
	<td style="width: 30%; vertical-align: top;">
	  Map type:&nbsp;
	  <select name="gmt_map_type" onchange="gmt_overwrite_shortcode()">
		<?php $gmt_map_type = array("ROADMAP","SATELLITE", "HYBRID", "TERRAIN") ?>
		<?php foreach ($gmt_map_type as $maptype) : ?>
  		<option <?= ((@$gmtdata['type'] == $maptype) ? "selected" : "") ?> value="<?= $maptype ?>"><?= $maptype ?></option>
		<?php endforeach; ?>
	  </select><br />
	  <?php if (empty($gmtdata['width'])): ?>
  	  Map width: <input type="text" name="gmt_map_width" value="600" onchange="gmt_overwrite_shortcode()" /><br />
  	  Map height: <input type="text" name="gmt_map_height" value="500" onchange="gmt_overwrite_shortcode()" /><br />
  	  Map zoom: 4<br />
  	  Latitude: <span id="gmt_latitude">50.261254</span><br />
  	  Longitude: <span id="gmt_longitude">12.121581</span><br />
	  Position:&nbsp;
  	  <select name="gmt_map_position" onchange="gmt_move_map()">
		  <?php $gmt_map_position = array("none", "left", "right") ?>
		  <?php foreach ($gmt_map_position as $position) : ?>
			<option value="<?= $position ?>"><?= $position ?></option>
		  <?php endforeach; ?>
  	  </select><br />
	  <?php else: ?>
  	  Map width: <input type="text" name="gmt_map_width" value="<?= $gmtdata["width"] ?>" onchange="gmt_overwrite_shortcode()" /><br />
  	  Map height: <input type="text" name="gmt_map_height" value="<?= $gmtdata["height"] ?>" onchange="gmt_overwrite_shortcode()" /><br />
  	  Map zoom: <span id="gmt_zoom"><?= $gmtdata["zoom"] ?></span><br />
  	  Latitude: <span id="gmt_latitude"><?= $gmtdata["latitude"] ?></span><br />
  	  Longitude: <span id="gmt_longitude"><?= $gmtdata["longitude"] ?></span><br />
  	  Position:&nbsp;
  	  <select name="gmt_map_position" onchange="gmt_move_map()">
		  <?php $gmt_map_position = array("none", "left", "right") ?>
		  <?php foreach ($gmt_map_position as $position) : ?>
			<option <?= (($gmtdata['position'] == $position) ? "selected" : "") ?> value="<?= $position ?>"><?= $position ?></option>
		  <?php endforeach; ?>
  	  </select><br />
	  <?php endif; ?>
	</td>
  </tr>
</table>
<br />

<?php if (empty($gmtdata['width'])): ?>
  <div id="gmt_map_canvas" style="height: 500px; width: 600px"></div>
<?php else: ?>
  <div id="gmt_map_canvas" class="gmt_<?= $gmtdata["position"] ?>_map_position" style="height: <?= $gmtdata["height"] ?>px; width: <?= $gmtdata["width"] ?>px;float:<?= $gmtdata["position"] ?>"></div>
  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu leo nec elit pretium aliquam non imperdiet augue.
  Integer ac dui nec nisl interdum aliquet. Morbi varius est nec mauris gravida eget vehicula velit ullamcorper.
  Nullam scelerisque libero id quam suscipit posuere. Integer semper diam ut massa pellentesque vestibulum. In nec diam elit.
  Nam eget diam dui. Maecenas rhoncus aliquam est, eu lobortis neque tincidunt aliquet. Aliquam ornare aliquet vehicula. Suspendisse eu sapien mi.

Duis imperdiet adipiscing mauris in sollicitudin. Vivamus tempus risus eget ligula congue elementum. Nam in rutrum purus.
Nam quis orci lectus. Cras quam odio, rutrum quis elementum nec, interdum sed diam. Integer sed quam erat, quis sodales tellus.
Aenean vulputate elit non lacus luctus bibendum. Praesent egestas iaculis eros, quis dictum arcu ultricies eu.

Donec quis neque sapien, nec rhoncus ante. Aenean id pulvinar enim. Suspendisse potenti. Nunc lacinia viverra magna, ut egestas mi suscipit sed.
Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean consectetur erat sed dolor hendrerit suscipit.
Cras convallis tempus justo, pharetra blandit turpis dignissim sed. Donec interdum elementum leo.

Nunc non mi nunc. Nunc sapien quam, ultricies nec molestie non, pellentesque sit amet nisi. Donec et est turpis.
Phasellus tincidunt tincidunt metus, ut porta odio dictum id. Donec blandit quam at lectus porta eu posuere orci dictum. Nulla facilisi.
Duis dictum augue viverra magna ultrices suscipit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
Mauris orci augue, hendrerit ac condimentum sit amet, laoreet in dolor. Donec pretium, neque nec accumsan cursus,
elit lacus rutrum purus, dignissim ullamcorper tortor urna ac risus. Etiam ornare erat sit amet nisl rutrum id porttitor ipsum vehicula.
Vestibulum adipiscing, lacus eu egestas porta, libero turpis placerat nisl, vitae tincidunt turpis ante placerat tortor.
Vivamus eleifend tincidunt cursus. Nam vestibulum purus eget nibh sagittis id lacinia arcu rutrum.
<?php endif; ?>

<?php if (empty($gmtdata['latitude'])): ?>
  <input type="hidden" name="gmt_latitude" value="50.261254" />
  <input type="hidden" name="gmt_longitude" value="12.121581" />
  <input type="hidden" name="gmt_map_zoom" value="4" />
<?php else: ?>
  <input type="hidden" name="gmt_latitude" value="<?= $gmtdata["latitude"] ?>" />
  <input type="hidden" name="gmt_longitude" value="<?= $gmtdata["longitude"] ?>" />
  <input type="hidden" name="gmt_map_zoom" value="<?= $gmtdata["zoom"] ?>" />
<?php endif; ?>

<input type="hidden" name="gmt_post_id" value="<?= $_GET['post'] ?>" />
<input type="hidden" name="gmt_data" value="1" />

<script type="text/javascript">

  jQuery(document).ready(function(){
<?php if (empty($gmtdata['latitude'])): ?>
  	gmt_initMap(50.261254, 12.121581,"ROADMAP",4);
<?php else: ?>
  	gmt_initMap(<?= $gmtdata["latitude"] ?>, <?= $gmtdata["longitude"] ?>, "<?= $gmtdata["type"] ?>",<?= $gmtdata["zoom"] ?>);
<?php endif; ?>
  });


  function gmt_initMap(Lat,Lng,maptype,mapzoom) {
	var latLng = new google.maps.LatLng(Lat, Lng);
	var homeLatLng = new google.maps.LatLng(Lat, Lng);

	switch(maptype){
	  case "SATELLITE":
		maptype=google.maps.MapTypeId.SATELLITE;
		break;

	  case "HYBRID":
		maptype=google.maps.MapTypeId.HYBRID;
		break;

	  case "TERRAIN":
		maptype=google.maps.MapTypeId.TERRAIN;
		break;

	  default:
		maptype=google.maps.MapTypeId.ROADMAP;
		break;
    }

	var map = new google.maps.Map(document.getElementById('gmt_map_canvas'), {
	  zoom: mapzoom,
	  center: latLng,
	  mapTypeId: maptype
	});

	var marker = new MarkerWithLabel({
	  position: homeLatLng,
	  draggable: true,
	  map: map
	});

	var iw = new google.maps.InfoWindow({
<?php if (empty($gmtdata["info"])): ?>
  			content: '<span id="gmt_tooltip">Set text<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></span>'
<?php else: ?>
  <?php
  $info = str_replace("\r\n", "<br />", $gmtdata["info"]);
  ?>
  							content: '<span id="gmt_tooltip"><?= $info ?></span>'
<?php endif; ?>

						});
						google.maps.event.addListener(marker, "click", function (e) { iw.open(map, marker); });
						google.maps.event.addListener(marker, "dragend", function () {gmt_set_coordinates(marker.position.toString()); });
						google.maps.event.addListener(map, "zoom_changed", function () {gmt_set_zoom(map.zoom)});
					  };
</script>


