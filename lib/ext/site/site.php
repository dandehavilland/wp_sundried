<?php

define("SITE_PATH", dirname(__FILE__));

require(SITE_PATH."/site_widgets.php");
require(SITE_PATH."/site_settings.php");
/**
* 
* 
*/
if (!class_exists("WPS_Site")):
	
	class WPS_Site extends WPS_UIExtension {
	
		var $scripts = array(
			'wps_site' => array('src' => '/site/scripts/site.js', 'deps' => array('jquery'))
		);
	
		function __construct() {
			parent::__construct();
			add_action('init', array(&$this, 'initialize_menus'));
			add_action('init', array(&$this, 'initialize_sidebars'));
			add_action('init', array(&$this, 'add_theme_preferences'));
			add_action('init', array(&$this, 'initalize_taxonomies'));
		}
	
		function add_theme_preferences() {
			add_image_size('feature_banner', 830, 260, true);
		}
		
		function initalize_taxonomies() {
      
		}
	
		function initialize_menus() {
			register_nav_menu('primary', "Primary");
			register_nav_menu('top_right', "Top Right");
			register_nav_menu('footer', "Footer");
		}
	
		function initialize_sidebars() {
			// 3 homepage columns
			register_sidebar( array(
				'name' => 'Homepage Widgets',
				'id' => 'homepage-widgets',
				'description' => 'The widgets on the homepage',
				'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		}
	
	}
	
	// helper functions
	
	function __post_id($post_id=null) {
		global $post;
		if ($post_id == null) $post_id = $post->ID;
		return $post_id;
	}
	
	function single_product_category_title() {
	  $cats = product_categories();
	  return $cats[0]->name;
	}
	
	function single_product_category_link() {
	  $cats = product_categories();
	  print_r();die;
	  return '<a href="'.get_term_link($cats[0]->slug, 'wpsc_product_category').'">'.$cats[0]->name.'</a>';
	}
	
	function product_category_links($sep=", ") {
	  $arr = array();
	  foreach (product_categories() as $term) {
	    $arr[] = '<a href="'.get_term_link($term->slug, 'wpsc_product_category').'">'.$term->name.'</a>';
	  }
	  
	  return join($sep, $arr);
	}
	
	function product_categories() {
	  global $post;
	  return wp_get_object_terms($post->ID, 'wpsc_product_category');
	}
	
	function split_content_into_columns() {
	  global $post, $more, $wp_query;

    $template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
	  
	  $output = '<div class="column">';
	  
	  $more = 1;
	  $content = get_the_content();
	  
	  $content = str_replace('<span id="more-'.$post->ID.'"></span>', "</div>".$output, $content);
	  
	  $content = apply_filters('the_content', $content);
    $output .= str_replace(']]>', ']]&gt;', $content);
    
    
    $output .= "</div>";
    
    echo $output;
	}
	
	new WPS_Site;
endif;
