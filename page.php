<?php if (is_front_page()):
require dirname(__FILE__)."/home.php";

else:
/**
 * Template: Page.php
 *
 * @package wp_sundried
 * @subpackage Template
 */
global $post;
get_header();
?>
<div class="primary hfeed">
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<div class="entry_wrapper" id="post_<?php the_ID(); ?>">
		<h2 class="entry_title">
		  <?php if (is_single() && wpsc_the_product_id() != null): ?>
		  <?=product_category_links(); ?>
		  <?php else: ?>
		  <?php the_title(); ?>
		  <?php endif;?>
		</h2>
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
<?php endif; ?>