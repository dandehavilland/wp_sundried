<div class="entry_wrapper" id="post_<?php the_ID(); ?>">
	<h2 class="entry_title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	<?php render_partial('entry/author_info'); ?>
	<div class="entry_content article">
		<div class="entry_attachment">
			<?php echo wp_get_attachment_link( $post->ID, 'medium', false, true); ?>
		</div>
		<?php the_content(); ?>
	</div>
	<?php render_partial('entry/meta'); ?>
</div>
