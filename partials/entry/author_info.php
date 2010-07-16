<div class="entry_meta entry_header">
	<span class="author vcard">Written by <?php printf( '<a class="url fn" href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( 'View all posts by %s', $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></span>
	<span class="published">on <abbr class="published_time" title="<?php the_time( get_option('date_format') .' - '. get_option('time_format') ); ?>"><?php the_time( get_option('date_format') ); ?></abbr></span>
	<span class="meta_separator">&mdash;</span>
	<span class="comment_count"><a href="<?php comments_link(); ?>"><?php comments_number( 'Leave a Comment', '1 Comment', '% Comments' ); ?></a></span>
	<?php edit_post_link( 'edit', '<span class="edit_post admin_control">[', ']</span>' ); ?>
</div>