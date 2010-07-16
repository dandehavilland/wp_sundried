<?php
/**
 * Template: Date.php
 *
 * @package wp_sundried
 * @subpackage Template
 */

get_header();
?>
<div class="primary hfeed">
<?php if ( have_posts() ) : ?>
	<h1 class="page_title archive_title">
	<?php /* If this is a daily archive */ if ( is_day() ) { ?>
	Daily Archives: <span class="daily-title"><?php the_time( 'F jS, Y' ); ?></span>
	<?php /* If this is a monthly archive */ } elseif ( is_month() ) { ?>
	Monthly Archives: <span class="monthly-title"><?php the_time( 'F, Y' ); ?></span>
	<?php /* If this is a yearly archive */ } elseif ( is_year() ) { ?>
	Yearly Archives: <span class="yearly-title"><?php the_time( 'Y' ); ?></span>
	<?php } ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php render_partial('excerpt'); ?>
	<?php endwhile; ?>
	<?php render_partial('navigation'); ?>
<?php else : ?>
	<?php render_partial('not_found'); ?>
<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>