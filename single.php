<?php
/**
 * Template: Single.php
 *
 * @package wp_sundried
 * @subpackage Template
 */

get_header();
?>
<div class="primary hfeed">
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php render_partial('entry'); ?>
		<?php comments_template( '', true ); ?>
		<?php render_partial('navigation'); ?>
	<?php endwhile; ?>
<?php else : ?>
	<?php render_partial('not_found'); ?>
<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>