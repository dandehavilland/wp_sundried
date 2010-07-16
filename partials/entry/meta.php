<div class="entry_meta entry_footer">
	<span class="entry_categories">Posted in <?php the_category( ', ' ); ?></span>
	<?php if ( $tag_list = get_the_tag_list( '', ', ' ) ) { ?>
	<span class="meta_separator">|</span>
	<span class="entry_tags">Tagged <?php echo $tag_list; ?></span>
    <?php } ?>
</div>