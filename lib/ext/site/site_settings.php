<?php

if (!class_exists("WPS_SiteSettings")):
define("HOMEPAGE_SETTINGS_PREFIX", "homepage");
global $homepage_overlays;
$homepage_overlays = array(
  'main' => array(
    'black_star' => array(
      'label' => 'Black star', 
      'text_style' => "top: 149px;left: 70px;color: #9FE6D9;width: 88px;text-align: center;transform: rotate(-14deg);-ms-transform: rotate(-14deg);-moz-transform: rotate(-14deg);-webkit-transform: rotate(-14deg);-o-transform: rotate(-14deg);", 
      'src' => "/wp-content/themes/wp_sundried/assets/images/main-black-star-overlay.png",
      'width' => 370,
      'height' => 305)),
      
  'top_right' => array(
    'envelope' => array(
      'label' => 'Envelope', 
      'text_style' => "", 
      'src' => "",
      'width' => 220,
      'height' => 160)),
      
  'bottom_right' => array(
    'hand' => array(
      'label' => "Hand", 
      'text_style' => "", 
      'src' => "",
      'width' => 220,
      'height' => 120))
);

/**
 * Adds the settings menu under the 'Dashboard' tab in site admin
 *
 * @author Dan de Havilland
 */
class WPS_SiteSettings {
	
	function __construct() {
		add_action('admin_menu', array(&$this, 'add_homepage_settings_menu'));
	}
	
	function add_homepage_settings_menu() {
		add_submenu_page( 'index.php', 'Homepage', 'Homepage', 'edit_posts', 'homepage_settings', array(&$this, 'show_homepage_settings_page') );
	}
	function show_homepage_settings_page() {
		global $post, $homepage_overlays;
		if (!current_user_can('edit_posts'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		
		
		
		$nonce_name = "_home_nonce";
		$nonce_value = wp_create_nonce($nonce_name);
		$form_prefix = HOMEPAGE_SETTINGS_PREFIX;
		
		$positions = array(
			'main' => "Main",
			'right_top' => "Right Top",
			'right_bottom' => "Right Bottom"
		);
		
		query_posts('post_type=wpsc-product&posts_per_page=-1');
		
		if (isset($_POST[$form_prefix])) {
			// process the data and save to the options table
			update_option($form_prefix, $_POST[$form_prefix]);
			$updated = true;
		}
		
		// read data from the options table
		$values = get_option($form_prefix);
		
		include(dirname(__FILE__)."/views/homepage/edit.php");
	}
}

$homepage_settings = new WPS_SiteSettings;

/**
 * Returns an associative array representing the saved choices for the
 * homepage content.
 * 
 * E.g. array('left' => 1, 'center' => 2, 'right' => 3, 'bottom' => 4)
 * 
 * @return array
 * @author Dan de Havilland
 */
function get_homepage_page_ids() {
	$settings = get_option(HOMEPAGE_SETTINGS_PREFIX);
	$ids = $settings['home'];
	return empty($ids) ? -1 : $ids;
}

function get_homepage_page_features() {
	$settings = get_option(HOMEPAGE_SETTINGS_PREFIX);
	return $settings['home'];;
}

function determine_location($homepage_page_ids, $post_id=null) {
	global $post;
	if ($post_id == null) $post_id = $post->ID;
	foreach ($homepage_page_ids as $key => $id)
		if ($id == $post_id) return $key;
	
	return false;
}

endif;

?>