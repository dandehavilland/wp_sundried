<?php
/**
* DDUseragent
* @author Dan de Havilland
* @version 1.0
* 
*/
if (!class_exists("DDUseragent")):
class DDUseragent extends WPS_UIExtension {
	var $scripts = array(
		'dd_useragent' => array(
			'src' => "/dd_useragent/scripts/dd_useragent.js",
			'deps' => array("jquery")
		));
}
new DDUseragent;
endif;
?>