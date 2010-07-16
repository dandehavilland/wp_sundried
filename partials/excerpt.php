<div class="entry_wrapper hentry" id="post_<?php the_ID(); ?>">
	<h2 class="entry_title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	<?php render_partial('entry/author_info'); ?>
	<div class="entry_excerpt article">
		<?php the_excerpt(); ?>
	</div>
	<?php render_partial('entry/meta'); ?>
</div>
