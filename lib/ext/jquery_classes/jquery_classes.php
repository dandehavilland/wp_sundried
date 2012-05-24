<?php


if (!class_exists("jQueryClassesExtension")):

/**
* jQueryClassesExtension
*/
class jQueryClassesExtension {
	
	var $is_theme_extension = true;
	
	var $scripts = array(
		"jquery_classes" => array(
			'src' => "/jquery.class.js",
			'deps' => array('jquery')
		)
	);
	
	var $styles = array();
	
	function __construct() {
		if ($this->is_theme_extension) {
			$this->assets_uri = get_template_directory_uri()."/lib/ext/jquery_classes";
			$this->assets_dir = get_template_directory()."/lib/ext/jquery_classes";
		} else {
			$this->assets_uri = plugin_dir_url(__FILE__);
			$this->assets_dir = plugin_dir_path(__FILE__);
		}
		
		add_action('init', array(&$this, 'enqueue_assets'));
	}
	
	function enqueue_assets() {
		foreach ($this->scripts as $handle => $params) {
			wp_enqueue_script($handle,
				$this->assets_uri."/scripts".$params["src"],
				isset($params['deps']) ? $params['deps'] : array(),
				isset($params['ver']) ? $params['ver'] : false,
				isset($params['in_footer']) ? $params['in_footer'] : false);
		}
		
		foreach ($this->styles as $handle => $params) {
			wp_enqueue_style($handle,
				!empty($params["src"]) ? $this->assets_uri."/styles".$params["src"] : false,
				isset($params['deps']) ? $params['deps'] : array(),
				isset($params['ver']) ? $params['ver'] : false,
				isset($params['media']) ? $params['media'] : false);
		}
	}
}
new jQueryClassesExtension;
endif;

?>