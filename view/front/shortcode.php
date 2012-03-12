<div id="gmt_map_<?= $post_id ?>" class="gmt_<?= $position ?>_map_position gmt_maps" style="width: <?= $width ?>px; height:<?= $height ?>px;float:<?= $position ?>"></div>
<?php $info = str_replace("\r\n", "<br />", $info); ?>
<script type="text/javascript">
  jQuery(document).ready(function(){
	gmt_init_map(<?= $latitude ?>,<?= $longitude ?>, "gmt_map_<?= $post_id ?>", <?= $zoom ?>, "<?= $type ?>","<?= $info ?>");
  });
</script>


