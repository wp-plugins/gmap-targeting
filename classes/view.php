<?php

class GMT_View {

  public function render_admin($view, $data=array()) {
	extract($data);
	include(GMT_PLUGIN_PATH . '/view/admin/admin_header.php' );
	include(GMT_PLUGIN_PATH . '/view/admin/' . $view . '.php' );
	include(GMT_PLUGIN_PATH . '/view/admin/admin_footer.php' );
  }

  public function render_front($view, $data=array()) {
	extract($data);
	ob_start();
	include(GMT_PLUGIN_PATH . '/view/front/' . $view . '.php');
	return ob_get_clean();
  }

}

