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
function render_partial( $partial_name, $echo=true ) {
	if ($echo) return require( WPS_PARTIALS . "/{$partial_name}.php" );
	else {
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
			isset($params["src"]) ? $params["src"] : null,
			isset($params["deps"]) ? $params["deps"] : null,
			isset($params["ver"]) ? $params["ver"] : null,
			isset($params["in_footer"]) ? $params["in_footer"] : null
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
 * include_all() A function to include all files from a directory path
 *
 * @since 0.1
 * @credits k2
 */
function include_all( $path, $exclude = false, $include = false ) {

	/* Open the directory */
	$dir = @dir( $path ) or die( 'Could not open required directory ' . $path );
	
	/* Get all the files from the directory */
	while ( ( $file = $dir->read() ) !== false ) {
		/* Check the file is a file, and is a PHP file */
		if ( is_file( $path . $file ) && ( !$exclude && !in_array( $file, $exclude ) ) && preg_match( '/\.php$/i', $file ) ) {
			require_once( $path . $file );
		} elseif (is_dir( $path . $file )) {
			if (file_exists( $child_script = $path . $file . "/{$file}.php" ))
				require_once( $child_script );
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

?>