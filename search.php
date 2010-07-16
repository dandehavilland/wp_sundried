<?php
/**
 * Template: Search.php
 *
 * @package wp_sundried
 * @subpackage Template
 */

get_header();
?>
<div class="primary hfeed">
<?php if ( have_posts() ) : ?>
	<h1 class="page_title search_title">Search Results for: <?php the_post(); echo '<span class="search_term">'. $s .'</span>'; rewind_posts(); ?></h1>
             
	<ol class="search_query">
	<?php while ( have_posts() ) : the_post(); ?>

	<li class="search_result" id="result_post_<?php the_ID(); ?>">
	<?php render_partial('excerpt'); ?>
	</li>

	<?php endwhile; ?>
	</ol>
	<?php render_partial('navigation'); ?>
	<?php else : ?>

	<div class="entry_wrapper not_found" id="post_0">
		<h2 class="entry_title">Your search for "<?php echo "$s"; ?>" did not match any entries</h2>
		<div class="entry_content">
			<?php get_search_form(); ?>
			<p>Suggestions:</p>
			<ul>
				<li>Make sure all words are spelled correctly.</li>
				<li>Try different keywords.</li>
				<li>Try more general keywords.</li>
			</ul>
		</div>
	</div>

<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>