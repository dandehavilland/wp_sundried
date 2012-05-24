<?php
/**
* SammyJS inclusion
* @author Dan de Havilland
* @version 0.1
* 
*/
if (!class_exists("SammyJS")):
class SammyJS extends WPS_UIExtension {
	var $scripts = array(
		'sammyjs' => array(
			'src' => "/sammyjs/scripts/sammy.js",
			'deps' => array("jquery")
		));
}
new SammyJS;
endif;
?>