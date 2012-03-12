<?php

class GMT_Model {

  const TABLE_MAP_INFORMATION = "gmap_targeting_map_info";
  const TABLE_COORDINATES = "gmap_targeting_coordinates";
  const TABLE_GALLERY = "gmap_targeting_gallery";

  private $db;

  public function __construct() {
	global $wpdb;
	$this->db = $wpdb;
  }

  public function get_post_data($post_id) {
	if(!$this->is_map_exists($post_id)){
	  return array();
	}

	$information = $this->db->get_results("SELECT * FROM " . self::TABLE_MAP_INFORMATION . " WHERE post_id=$post_id LIMIT 1", ARRAY_A);
	$information = $information[0];
	$coordinates = $this->db->get_results("SELECT * FROM " . self::TABLE_COORDINATES . " WHERE post_id=$post_id LIMIT 1", ARRAY_A);
	$coordinates = $coordinates[0];
	return array_merge($information, $coordinates);
  }

  public function save_post_data($data) {
	$post_id = (int) $data['post_ID'];
	$is_mapinfo_exists = $this->is_map_exists($post_id);

	if ($is_mapinfo_exists) {
	  $this->db->update(self::TABLE_MAP_INFORMATION, array('info'=>$data['gmt_info'], 'width' => $data['gmt_map_width'], 'height' => $data['gmt_map_height'], 'zoom' => $data['gmt_map_zoom'], 'type' => $data['gmt_map_type'], 'position' => $data['gmt_map_position']), array('post_id' => $post_id));
	} else {
	  $this->db->insert(self::TABLE_MAP_INFORMATION, array('post_id' => $post_id, 'info' => $data['gmt_info'], 'width' => $data['gmt_map_width'], 'height' => $data['gmt_map_height'], 'zoom' => $data['gmt_map_zoom'], 'type' => $data['gmt_map_type'], 'position' => $data['gmt_map_position']));
	}
	//***
	$is_coordinates_exists = $this->db->get_var("SELECT id FROM " . self::TABLE_COORDINATES . " WHERE post_id = $post_id");
	if ($is_coordinates_exists) {
	  $this->db->query("UPDATE " . self::TABLE_COORDINATES . " SET latitude=\"{$data['gmt_latitude']}\", longitude=\"{$data['gmt_longitude']}\" WHERE post_id=$post_id");
	} else {
	  $this->db->insert(self::TABLE_COORDINATES, array('post_id' => $post_id, 'latitude' => $data['gmt_latitude'], 'longitude' => $data['gmt_longitude']));
	}
	//***
  }

  private function is_map_exists($post_id) {
	return (bool)$this->db->get_var("SELECT id FROM " . self::TABLE_MAP_INFORMATION . " WHERE post_id= $post_id");;
  }

}

