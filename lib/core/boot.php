<?php
/**
 * wp_sundried/WordPress interaction core
 *
 * @package wp_sundried
 * @subpackage Functions
 */

/**
 * class wp_sundried Main class loads all includes, adds/removes filters.
 * 
 * @since 0.1
 */

if (!class_exists('wp_sundried')):
define( 'WPS_CONF', TEMPLATEPATH . '/config/conf.yml' );
class wp_sundried {
	
	public static $version = 0.1;
	
	/**
	 * init() Initialisation method which calls all other methods in turn.
	 *
	 * @since 0.1
	 */
	function initialize() {
		$theme = new wp_sundried;
		
		$theme->environment();
		$theme->framework();
		$theme->extentions();
		$theme->defaults();
		$theme->ready();
		
		do_action( 'wp_sundried_init' );
	}
	
	/**
	 * config() Retrieve configuration values from config/environment.ini
	 *
	 * Tries to use the Syck YAML parser C libs if available. Falls back on
	 * the included (but slower) buy Spyc YAML parser
	 * 
	 * @since 0.1
	 */
	public static function config($base=null) {
		if (!isset($this->config)) {
			if (function_exists('syck_load'))
				$this->config = syck_load();
			else {
				require( TEMPLATEPATH . '/core/spyc.php' );
				$this->config = spyc_load(WPS_CONF);
			}
		}
		
		if (!empty($base)) return $this->config[$base];
		else return $this->config;
	}
	
	/**
	 * environment() defines wp_sundried directory constants
	 *
	 * @since 0.1
	 */
	function environment() {
		
		define('WPS_LIB', TEMPLATEPATH . '/lib');
		define('WPS_CORE', WPS_LIB . '/core');
		define('WPS_EXT', WPS_EXT . '/ext');
		define('WPS_PARTIALS', TEMPLATEPATH . '/partials' );
		define('TEMPLATEURL', get_bloginfo('template_url'));
		
		$env_conf = wp_sundried::config('env');
		
		foreach ($env_conf['paths'] as $label => $path) {
			$label = strtoupper($label);
			define("WPS_{$label}", TEMPLATEPATH . "/{$path}");
			define("WPS_{$label}_URL", TEMPLATEURL . "/{$path}");
		}
		
		do_action( 'wp_sundried_environment' ); // Available action: load_environment
	}
	
	/**
	 * framework() includes all the core functions for wp_sundried
	 *
	 * @since 0.1
	 */
	function framework() {
		require_once( WPS_CORE . '/hooks.php' );
		require_once( WPS_CORE . '/functions.php' );
		require_once( WPS_CORE . '/comments.php' );
		require_once( WPS_CORE . '/widgets.php' );
		
		do_action( 'wp_sundried_framework' );
	}
	
	/**
	 * extentions() includes all extentions if they exist
	 *
	 * @since 0.1
	 */
	function extentions() {
		include_all( WPS_EXT );
	}
	
	/**
	 * defaults() connects wp_sundried default behavior to their respective action
	 *
	 * @since 0.1
	 */
	function defaults() {
		add_filter( 'the_generator', 'remove_generator_link', 1 ); // remove_generator_link() Removes generator link - Credits: (http://www.plaintxt.org)
		add_filter( 'post_gallery', 'semantic_gallery' ); // stops [gallery] styles from being added to the page. making html invalid
		add_filter( 'wp_page_menu', 'framework_menu_ulclass' ); // adds a .nav class to the ul wp_page_menu generates
		add_action( 'init', 'framework_assets' ); // framework_assets() loads scripts and styles
	}
	
	/**
	 * ready() includes user's theme.php if it exists, calls the wp_sundried_init action, includes all pluggable functions and registers widgets
	 *
	 * @since 0.1
	 */
	function ready() {
		if ( file_exists( WPS_ASSETS . '/custom-functions.php' ) ) include_once( WPS_ASSETS . '/custom-functions.php' ); // include custom-functions.php if that file exist
		require_once( WPS_CORE . '/pluggable.php' ); // load pluggable functions
		do_action( 'wp_sundried_init' ); // Available action: wp_sundried_init
		register_widgets();
	}
}
endif;
?>