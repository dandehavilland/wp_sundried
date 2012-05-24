<?php
/**
 * Functions
 *
 * @package wp_sundried
 * @subpackage Functions
 */

/**
 * render_partial()
 *
 * @since 0.1
 */
function render_partial( $partial_name, $echo=true, $params=array() ) {
	global $post;
	
	extract($params);
	
	if ($echo) {
		return require( WPS_PARTIALS . "/{$partial_name}.php" );
	} else {
		ob_start();
		require ( WPS_PARTIALS . "/{$partial_name}.php");
		return ob_get_clean();
	}
}
/**
 * framework_assets() loads scripts and styles
 *
 * @since 0.1
 */
function framework_assets() {
	if( is_admin() ) return;
	$env_conf = wp_sundried::config('env');
	
	foreach ($env_conf['scripts'] as $handle => $params) {
		wp_enqueue_script(
			$handle,
			!empty($params["src"]) ? WPS_SCRIPTS_URL."/{$params["src"]}" : null,
			!empty($params["deps"]) ? $params["deps"] : null,
			!empty($params["ver"]) ? $params["ver"] : (!empty($params["src"]) ? @filemtime(WPS_SCRIPTS."/{$params["src"]}"): null),
			!empty($params["in_footer"]) ? $params["in_footer"] : null
		);
	}
}

/**
 * remove_generator_link() Removes generator link
 *
 * @since 0.1
 * @credits http://www.plaintxt.org
 * @needsdoc
 */
function remove_generator_link() { return ''; }

/**
 * post_gallery_filter stops [gallery] styles from being added to the page. making html invalid
 *
 * @since 0.1
 * @needsdoc
 */
function gallery_style_filter( $gallery ) { return '<div class="gallery">'; }

/**
 * framework_menu - adds css class to the <ul> tag in wp_page_menu.
 *
 * @since 0.1
 * @filter framework_menu_ulclass
 * @needsdoc
 */
function framework_menu_ulclass( $ulclass ) {
	$classes = apply_filters( 'framework_menu_ulclass', (string) 'nav' ); // Available filter: framework_menu_ulclass
	return preg_replace( '/<ul>/', '<ul class="'. $classes .'">', $ulclass, 1 );
}

/**
 * framework_nice_terms clever terms
 *
 * @since 0.1
 * @needsdoc
 */
function framework_nice_terms( $term = '', $normal_separator = ', ', $penultimate_separator = ' and ', $end = '' ) {
	if ( !$term ) return;
	switch ( $term ):
		case 'cats':
			$terms = framework_get_terms( 'cats', $normal_separator );
			break;
		case 'tags':
			$terms = framework_get_terms( 'tags', $normal_separator );
			
			break;
	endswitch;
	if ( empty($term) ) return;
	$things = explode( $normal_separator, $terms );
	
	$thelist = '';
	$i = 1;
	$n = count( $things );
		
	foreach ( $things as $thing ) {
		
		$data = trim( $thing, ' ' );
		
		$links = preg_match( '/>(.*?)</', $thing, $link );
		$hrefs = preg_match( '/href="(.*?)"/', $thing, $href );
		$titles = preg_match( '/title="(.*?)"/', $thing, $title );
		$rels = preg_match( '/rel="(.*?)"/', $thing, $rel );
		
		if (1 < $i and $i != $n) {
			$thelist .= $normal_separator;
		}

		if (1 < $i and $i == $n) {
			$thelist .= $penultimate_separator;
		}
		$thelist .= '<a rel="'. $rel[1] .'" href="'. $href[1] .'"';
		if ( !$term = 'tags' )
			$thelist .= ' title="'. $title[1] .'"';
		$thelist .= '>'. $link[1] .'</a>';
		$i++;
	}
	$thelist .= $end;
	return apply_filters( 'framework_nice_terms', (string) $thelist );
}

/**
 * framework_get_terms() Returns other terms except the current one (redundant)
 *
 * @since 0.1
 * @usedby framework_entry_footer()
 */
function framework_get_terms( $term = NULL, $glue = ', ' ) {
	if ( !$term ) return;
	
	$separator = "\n";
	switch ( $term ):
		case 'cats':
			$current = single_cat_title( '', false );
			$terms = get_the_category_list( $separator );
			break;
		case 'tags':
			$current = single_tag_title( '', '',  false );
			$terms = get_the_tag_list( '', "$separator", '' );
			break;
	endswitch;
	if ( empty($terms) ) return;
	
	$thing = explode( $separator, $terms );
	foreach ( $thing as $i => $str ) {
		if ( strstr( $str, ">$current<" ) ) {
			unset( $thing[$i] );
			break;
		}
	}
	if ( empty( $thing ) )
		return false;

	return trim( join( $glue, $thing ) );
}

/**
 * framework_get Gets template files
 *
 * @since 0.1
 * @needsdoc
 * @action framework_get
 * @todo test this on child themes
 */
function framework_get( $file = NULL ) {
	do_action( 'framework_get' ); // Available action: framework_get
	$error = "Sorry, but <code>{$file}</code> does <em>not</em> seem to exist. Please make sure this file exist in <strong>" . get_stylesheet_directory() . "</strong>\n";
	$error = apply_filters( 'framework_get_error', (string) $error ); // Available filter: framework_get_error
	if ( isset( $file ) && file_exists( get_stylesheet_directory() . "/{$file}.php" ) )
		locate_template( get_stylesheet_directory() . "/{$file}.php" );
	else
        echo $error;
}

/**
 * load template
 *
 * @since 0.1
 * @author Dan de Havilland
 */
function include_template( $template_name ) {
	if (file_exists( $path = TEMPLATEPATH . "/{$template_name}.php" )) {
		include( $path );
	} elseif (file_exists( $path = WPS_CUSTOM_TEMPLATES . "/{$template_name}.php" )) {
		include( $path );
	}
}

// add_filter('template_directory_uri', 'wps_template_directory_uri');
// function wps_template_directory_uri() {
// 	
// }


/**
 * include_all() A function to include all files from a directory path
 *
 * @since 0.1
 * @credits k2
 */
function include_all( $path, $exclude = false ) {

	/* Open the directory */
	$dir = dir( $path ) or die( 'Could not open required directory ' . $path );
	/* Get all the files from the directory */
	while ( ( $file = $dir->read() ) !== false ) {
		/* Check the file is a file, and is a PHP file */
		$target = "{$path}/{$file}";
		
		if ( !$exclude || !in_array( $file, $exclude ) ) {
			if ( is_file( $target ) && preg_match( '/\.php$/i', $file ) ) {
				require_once( $target );
			} elseif (is_dir( $target ) ) {
				if (file_exists( $child_script = "{$path}/{$file}/{$file}.php" ))
					require_once( $child_script );
			}
		}
	}
	$dir->close(); // Close the directory, we're done.
}


/**
 * Gets the profile URI for the document being displayed.
 * @link http://microformats.org/wiki/profile-uris Profile URIs
 *
 * @since 0.1
 * @param integer $echo 0|1
 * @return string profile uris seperatd by spaces
 **/
function get_profile_uri( $echo = 1 ) {
	// hAtom profile
	$profile[] = 'http://purl.org/uF/hAtom/0.1/';
	
	// hCard, hCalendar, rel-tag, rel-license, rel-nofollow, VoteLinks, XFN, XOXO profile
	$profile[] = 'http://purl.org/uF/2008/03/';
	
	$profile = join( ' ', apply_filters( 'profile_uri',  $profile ) ); // Available filter: profile_uri
	
	if ( $echo ) echo $profile;
	else return $profile;
}
/**
 * body_classes
 * 
 * @since 0.1
 */
/**
 * body_classes
 * 
 * @since 0.1
 */
function body_classes() {
	$classes = array();
	$check = array('home', 'page', 'single', 'archive', 'category', 'tag', 'date', 'author', '404');
	
	foreach ($check as $type)
		if (call_user_func("is_".$type))
			$classes[] = $type;
	
	return join($classes, ' ');
}

/**
 * body_id
 * 
 * @since 0.1
 */
function body_id() {
	global $post;
	if (is_home()) $id = 'home'; 
	else if (is_archive()) $id = 'archive';
	else if (is_search()) $id = 'search';
	else if (is_category() || is_single()) $id = strtolower(single_category());
	else if (have_posts()) {
		the_post();
		$id = $post->post_name;
		rewind_posts();
	}
	return $id;
}

function write_to_cache($file_name, $data) {
	if (!is_dir(WPS_CACHE)) mkdir(WPS_CACHE, 0775);
	
	if (is_dir(WPS_CACHE) && is_writable(WPS_CACHE)) {
		$file_handle = fopen(WPS_CACHE."/{$file_name}", 'w');
		fwrite($file_handle, $data);
	} else {
		error_log("Error: could not write to cache (".WPS_CACHE."/{$file_name})");
	}
}

function cache_for($file_name) {
	if (is_file(WPS_CACHE . "/{$file_name}")) return WPS_CACHE . "/{$file_name}";
	else return false;
}

function cache_url_for($file_name) {
	if (is_file(WPS_CACHE . "/{$file_name}")) return WPS_CACHE_URL . "/{$file_name}";
	else return false;
}

function expire_cache_for($file_name) {
	if (is_file(WPS_CACHE . "/{$file_name}")) return unlink(WPS_CACHE_URL . "/{$file_name}");
}


function is_assoc($array) {
    return (is_array($array) && (count($array)==0 || 0 !== count(array_diff_key($array, array_keys(array_keys($array))) )));
}

function pprint_r($array, $return = false) {
	echo "<pre>";
	print_r($array, $echo);
	echo "</pre>";
	if (!$echo) die;
}

function get_post_thumbnail_src($post_id, $size='thumbnail') {
	$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size); 
	return $thumb[0];
}

function get_attachment_src($attachment_id, $size='thumbnail') {
	$attachment = wp_get_attachment_image_src($attachment_id, $size);
	return $attachment[0];
}

function get_thumbnail_images($post_id, $fetch_options=array(), $size='thumbnail') {
	global $_wp_additional_image_sizes;
	$attachments = get_posts(array_merge(array(
		'post_type' => 'attachment',
		'post_parent' => $post_id
	), $fetch_options));
	
	$output = array();
	
	foreach ($attachments as $attachment) {
		$meta = get_post_meta($attachment->ID, "_wp_attachment_metadata", true);
		
		if ($meta && $meta['width'] == $_wp_additional_image_sizes[$size]['width'] && $meta['height'] == $_wp_additional_image_sizes[$size]['height']) {
			$output[] = $attachment;
		}
	}
	
	return $output;
}

function the_index_link() {
	global $post;
	$permalink = get_permalink();
	if ($post->post_type == 'biography') {
		$director = new AF_Director(array_pop(wp_get_object_terms($post->ID, 'director')));
		$categories = get_terms('category', 'hide_empty=0');
		
		// pprint_r($categories);
		
		foreach ($categories as $category) {
			if ($director->term_has_posts($category->slug))
				return "/{$category->slug}/{$director->term->slug}/";
		}
		
	} elseif ($post->post_type == 'news') {
		return "/";
	} else {
		return preg_replace("/([^\/]+[\/]?)(attachment\/?)?$/", "", $permalink);
	}
}

	
// adapted from touch_time() WP3.1b2 /wp-admin/includes/template.php:579
function datetime_field($date, $prefix="", $suffix="") {
	global $wp_locale;
	
	if (!$date) $date = date('c', current_time('timestamp'));
	
	$jj = mysql2date( 'd', $date, false );
	$mm = mysql2date( 'm', $date, false );
	$aa = mysql2date( 'Y', $date, false );
	$hh = mysql2date( 'H', $date, false );
	$mn = mysql2date( 'i', $date, false );
	$ss = mysql2date( 's', $date, false );
	
	$month = '<select name="'.$prefix.'mm'.$suffix.'">\n';
	for ( $i = 1; $i < 13; $i = $i +1 ) {
		$month .= "\t\t\t" . '<option value="' . zeroise($i, 2) . '"';
		if ( $i == $mm )
			$month .= ' selected="selected"';
		$month .= '>' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) . "</option>\n";
	}
	$month .= '</select>';
	
	$day = '<input type="text" class="jj" name="'.$prefix.'jj'.$suffix.'" value="' . $jj . '" size="2" maxlength="2" autocomplete="off" />';
	$year = '<input type="text" class="aa" name="'.$prefix.'aa'.$suffix.'" value="' . $aa . '" size="4" maxlength="4" autocomplete="off" />';
	$hour = '<input type="text" class="hh" name="'.$prefix.'hh'.$suffix.'" value="' . $hh . '" size="2" maxlength="2" autocomplete="off" />';
	$minute = '<input type="text" class="mn" name="'.$prefix.'mn'.$suffix.'" value="' . $mn . '" size="2" maxlength="2" autocomplete="off" />';
	
	echo '<div class="timestamp-wrap">';
	/* translators: 1: month input, 2: day input, 3: year input, 4: hour input, 5: minute input */
	printf(__('%1$s%2$s, %3$s @ %4$s : %5$s'), $month, $day, $year, $hour, $minute);
	
	echo '</div><input type="hidden" name="'.$prefix.'ss'.$suffix.'" value="' . $ss . '" />';
	
}

function single_category() {
	global $post;
	$categories = get_the_category();
	if (count($categories) !== 0)  return $categories[0]->cat_name;
	else return false;
}
function single_category_id() {
	global $post;
	$categories = get_the_category();
	if (count($categories) !== 0)  return $categories[0]->cat_ID;
	return false;
}

//sherkspear
function add_iframe($initArray) {
	$initArray['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
	return $initArray;
}

add_filter('tiny_mce_before_init', 'add_iframe');

?>