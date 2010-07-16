<?php
/**
 * Template: Page.php
 *
 * @package wp_sundried
 * @subpackage Template
 */

get_header();
?>
<div class="primary hfeed">
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<div class="entry_wrapper" id="post_<?php the_ID(); ?>">
		<h1 class="entry_title"><?php the_title(); ?></h1>
			<?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
		<div class="entry_meta entry_header">
			<?php edit_post_link( 'edit', '<span class="edit_post admin_control">[', ']</span>' ); ?>
		</div>
		<?php endif; ?>
		<div class="entry_content article">
			<?php the_content(); ?>
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