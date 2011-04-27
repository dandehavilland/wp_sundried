<?php

/**
* WPS_UIExtension
*/
class WPS_UIExtension  {
	
	var $scripts = array();
	var $styles = array();
	
	function __construct() {
		add_action('init', array(&$this, 'enqueue_scripts'));
		add_action('init', array(&$this, 'enqueue_styles'));
	}
	
	function enqueue_scripts() {
		foreach ($this->scripts as $handle => $params) {
			wp_enqueue_script($handle,
				WPS_EXT_URL.$params["src"],
				isset($params['deps']) ? $params['deps'] : array(),
				isset($params['ver']) ? $params['ver'] : false,
				isset($params['in_footer']) ? $params['in_footer'] : false);
		}
	}
	
	function enqueue_styles() {
		foreach ($this->styles as $handle => $params) {
			wp_enqueue_style($handle,
				!empty($params["src"]) ? WPS_EXT_URL.$params["src"] : false,
				isset($params['deps']) ? $params['deps'] : array(),
				isset($params['ver']) ? $params['ver'] : false,
				isset($params['media']) ? $params['media'] : false);
		}
	}
}


/**
 * MetaBox Template
 *
 * @package wp_sundried
 * @author Dan de Havilland
 */
class WPS_PostMetaBox {
	
	var $meta_key, $box_title;
	var $post_type = 'post';
	var $position = 'side';
	var $context, $sub_context;
	var $views_root;
	var $nonce_name;
	var $priority = 'high';
	var $edit_include = 'edit.php';
	
	function __construct($params=array()) {
		foreach ($params as $key => $value)
			$this->{$key} = $value;
		
		$this->nonce_name = "{$this->meta_key}_nonce";
		
		add_action('admin_menu', array(&$this, 'register_meta_box'));
		add_action('save_post', array(&$this, 'update_product_meta'));
	}
	
	function register_meta_box() {
		add_meta_box(
			"{$this->meta_key}div", 
			$this->box_title, 
			array(&$this, 'edit_product_meta'), 
			$this->post_type,
			$this->position,
			$this->priority);
	}
	
	function edit_product_meta() {
		global $post;
		$data = get_post_meta($post->ID, $this->meta_key, true);
		include("{$this->views_root}/{$this->context}/{$this->sub_context}/{$this->edit_include}");
	}
	
	function update_product_meta($post_id) {
		if ( !wp_verify_nonce( $_POST[$this->nonce_name], $this->nonce_name)){
			return $post_id;
		}
			
		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;
		
		update_post_meta($post_id, $this->meta_key, $_POST[$this->meta_key]);
				
		return $_POST[$this->meta_key];
	}
}


?>