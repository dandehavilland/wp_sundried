<?php
/**
 * Functions - Framework gatekeeper
 *
 * This file defines a few constants variables, loads up the core framework file, 
 * and finally initialises the main wp_sundried Class.
 *
 * @package wp_sundried
 * @subpackage Functions
 */

require_once( TEMPLATEPATH . '/lib/boot.php' );
wp_sundried::init();
?>