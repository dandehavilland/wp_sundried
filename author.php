<?php
/**
 * Template: Author.php
 *
 * @package wp_sundried
 * @subpackage Template
 */

get_header();
?>
<div class="primary hfeed">
<?php if ( have_posts() ) : ?>
	<h1 class="page_title archive_title">Author Archives: <span class="author_title"><?php the_post(); echo $authordata->display_name; rewind_posts(); ?></span></h1>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php render_partial('entry'); ?>
	<?php endwhile; ?>
	<?php render_partial('navigation'); ?>
<?php else : ?>
	<?php render_partial('not_found'); ?>
<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>