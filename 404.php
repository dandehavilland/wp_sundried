<?php
/**
 * Template: 404.php
 *
 * @package wp_sundried
 * @subpackage Template
 */

header( "HTTP/1.1 404 Not found", true, 404 );
get_header();
?>
<div class="primary hfeed">
<?php render_partial('not_found'); ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>