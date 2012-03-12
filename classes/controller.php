<?php

include_once 'model.php';
include_once 'view.php';

class GMT_Controller {

  public $view, $model;

  public function __construct() {
	$this->view = new GMT_View();
	$this->model = new GMT_Model();
  }

  public function action_index() {
	$this->view->render_admin("index");
  }

  public function draw_post_panel($post_id) {
	$data["gmtdata"] = $this->model->get_post_data($post_id);
	$this->view->render_admin("post_panel", $data);
  }

  public function gmt_map_shortcode($attributes) {
	$attributes = $this->model->get_post_data($attributes['post_id']);
	if (!empty($attributes)) {
	  return $this->view->render_front("shortcode", $attributes);
	} else {
	  return "";
	}
  }

}

