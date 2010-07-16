<?php
/**
 * Template: Searchform.php
 *
 * @package wp_sundried
 * @subpackage Template
 */
?>
<form class="searchform" method="get" action="<?php bloginfo( 'url' ); ?>">
	<input class="search" name="s" type="text" value="Search..." tabindex="1" />
    <button class="search-btn" type="submit" tabindex="2">Search</button>
</form>