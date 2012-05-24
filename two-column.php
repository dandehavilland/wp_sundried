<?php
/**
 * Template Name: Two Columns (white)
 *
 * @package wp_sundried
 * @subpackage Template
 */
 
 

get_header();
?>
<div class="two-column primary hfeed">
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<div class="entry_wrapper" id="post_<?php the_ID(); ?>">
		<h2 class="entry_title"><?php the_title(); ?></h1>
		<div class="entry_content article">
		  <?php split_content_into_columns() ?>
		  <div class="clear"></div>
		</div>
		<!-- Auto Discovery Trackbacks
		<?php trackback_rdf(); ?>
		-->
	</div>
	<?php comments_template( '', true ); ?>
<?php endwhile; endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>