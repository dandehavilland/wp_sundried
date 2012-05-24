<?php
/**
 * Custom Functions - Theme Specific Functions
 *
 * Use this file to write any custom functions you may need.
 * To take advantage of wp_sundried's hook system, view them @ ( library/core/framework-hook-system.php )
 * To see what default behavior wp_sundried uses, view them @ ( library/framework.php )
 *
 * You'll find a few example functions below to get you started.
 * These are real functions and actually work, so try them out by uncommenting the lines to get a feel on how they all work.
 *
 * @package wp_sundried
 * @subpackage Template
 */

/* <- remove this line
// Example #1: Remove default behavior, simply call the remove_action with the first argument being the hook name, and the second argument being the hook function
remove_action( 'framework_hook_menu', 'framework_menu' );

// Example #2: Hook into a function by creating a function
// and calling the add_action with the first argument being the action you want to hook into, and the second argument being your function you just created.
function my_custom_function() {
	echo "Custom Function's rock!";
}
add_action( 'framework_hook_body_open', 'my_custom_function' );

// Example #3: To filter through a function, simply create the custom function with a parameter (can be any name) and return whatever you plan on doing with it
// Then call the add_filter function with the first argument being the filter you want to filter through, and the second argument being the function you just created.
function my_custom_filter( $content ){
	$content = 'My Custom filter is replacing the actual content!';
	return  $content;
}
add_filter( 'the_content', 'my_custom_filter' );
and remove this line -> */

add_filter('nav_menu_item_id', 'item_title_to_element_id', 10, 3);
function item_title_to_element_id($id, $item, $args) {
  if ($args->theme_location == "footer") {
    $lower = strtolower($item->title);
    $id = preg_replace('/[^a-z0-9]+/',"_", $lower);
  }
  
  return $id;
}

?>