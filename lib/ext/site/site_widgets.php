<?php

/**
 * GLWidget Template
 */
class GLWidget extends WPS_Widget {
	
	var $context = "widget";
	var $base_path = GL_PATH;
	var $views_root = "views";
	
	function widget($args, $instance) {
		$this->wq = new WP_Query($this->query_params);
		parent::widget($args, $instance);
	}
}

/**
 * GLEvents Widget Class
 */
class GLEvents_Widget extends GLWidget {
	
	var $name = "Events";
	var $meta_key = "gl_events";
	var $sub_context = "events";
	var $query_params = array(
		'category_name' => "events",
		'meta_key' => 'gl_event_start_date',
		'orderby' => 'meta_value',
		'order' => 'ASC'
	);
}
register_widget("GLEvents_Widget");


/**
 * GLEvent Widget Class
 */
class GLNews_Widget extends GLWidget {
	
	var $name = "News";
	var $meta_key = "gl_news";
	var $sub_context = "news";
	var $query_params = array(
		'category_name' => "news"
	);
}
register_widget("GLNews_Widget");


/**
 * GLReleases Widget Class
 */
class GLReleases_Widget extends GLWidget {
	
	var $name = "Releases";
	var $meta_key = "gl_releases";
	var $sub_context = "releases";
	var $query_params = array(
		'category_name' => "releases",
		'meta_key' => 'gl_release_date',
		'orderby' => 'meta_value',
		'order' => 'DESC'
	);
}
register_widget("GLReleases_Widget");


/**
 * GLMedia Widget Class
 */
class GLMedia_Widget extends GLWidget {
	
	var $name = "Media";
	var $meta_key = "gl_media";
	var $sub_context = "media";
	var $query_params = array(
		'category_name' => "media"
	);
}
register_widget("GLMedia_Widget");



/**
 * GLMedia Widget Class
 */
class GLTwitter_Widget extends GLWidget {
	
	var $name = "Twitter";
	var $meta_key = "gl_twitter";
	var $sub_context = "twitter";
	var $query_params = array();
}
register_widget("GLTwitter_Widget");

