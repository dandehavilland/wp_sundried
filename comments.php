<?php
/**
 * Template: Comments.php
 *
 * @package wp_sundried
 * @subpackage Template
 */

// Make sure comments.php doesn't get loaded directly
if ( !empty( $_SERVER[ 'SCRIPT_FILENAME' ] ) && 'comments.php' == basename( $_SERVER[ 'SCRIPT_FILENAME' ] ) )
	header('Location: /');

if ( post_password_required() ) { ?>
	<p class="password_protected alert">This post is password protected. Enter the password to view comments.</p>
<?php return; } ?>

<?php if ( have_comments() ) : // If comments exist for this entry, continue ?>
<!--BEGIN #comments-->
<div id="comments">
    
<?php if ( ! empty( $comments_by_type['comment'] ) ) { ?>
	<?php framework_discussion_title( 'comment' ); ?>
	<?php framework_discussion_rss(); ?>
	<ol class="comment_list">
		<?php wp_list_comments(array(
			'type' => 'comment',
			'callback' => 'framework_comments_callback',
			'end-callback' => 'framework_comments_endcallback' )); ?>
    </ol>
<?php } ?>

<?php if ( ! empty( $comments_by_type['pings'] ) ) { ?>
	<?php framework_discussion_title( 'pings' ); ?>
    <ol class="pings_list">
		<?php wp_list_comments(array(
			'type' => 'pings',
			'callback' => 'framework_pings_callback',
			'end-callback' => 'framework_pings_endcallback' )); ?>
	</ol>
<?php } ?>
</div>
<?php endif; ?>

<?php if ( comments_open() ): ?>
<div class="respond comment_form_wrapper">
	<div class="cancel_comment_reply"><?php cancel_comment_reply_link( 'Cancel Reply' ); ?></div>
	<h3 class="leave_a_reply"><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3> 

	<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
	<p class="login_req alert">You must be <a href="<?php echo get_option( 'siteurl' ); ?>/wp-login.php?redirect_to=<?php echo urlencode( get_permalink() ); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
	
	<form class="comment_form" method="post" action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php">
		
		<?php if ( is_user_logged_in() ) : global $current_user; // If user is logged-in, then show them their identity ?>

		<p>Logged in as <a href="<?php echo get_option( 'siteurl' ); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Log out of this account">Log out &raquo;</a></p>

		<div class="form_row form_author">
			<input name="author" id="author" type="text" value="<?php echo $current_user->user_nicename; ?>" tabindex="1" <?php if ( $req ) echo "aria-required='true'"; ?> />
			<label for="author"<?php if ( $req ) echo ' class="required"'; ?>>Name</label>
		</div>
		
		<div class="form_row form_email">
			<input name="email" id="email" type="text" value="<?php echo $current_user->user_email; ?>" tabindex="2" <?php if ( $req ) echo "aria-required='true'"; ?> />
			<label for="email"<?php if ( $req ) echo ' class="required"'; ?>>Email</label>
		</div>
		
		<div class="form_row form_url">
			<input name="url" id="url" type="text" value="<?php echo $current_user->user_url; ?>" tabindex="3" />
			<label for="url">Website</label>
		</div>
		
		<?php else: ?>
			
		<div class="form_row form_author">
			<input name="author" id="author" type="text" value="<?php echo $comment_author; ?>" tabindex="1" <?php if ( $req ) echo "aria-required='true'"; ?> />
			<label for="author"<?php if ( $req ) echo ' class="required"'; ?>>Name</label>
        </div>
        
        <!--BEGIN #form-section-email-->
        <div id="form-section-email" class="form-section">
            <input name="email" id="email" type="text" value="<?php echo $comment_author_email; ?>" tabindex="2" <?php if ( $req ) echo "aria-required='true'"; ?> />
            <label for="email"<?php if ( $req ) echo ' class="required"'; ?>>Email</label>
        <!--END #form-section-email-->
        </div>
		
        <!--BEGIN #form-section-url-->
        <div id="form-section-url" class="form-section">
            <input name="url" id="url" type="text" value="<?php echo $comment_author_url; ?>" tabindex="3" />
            <label for="url">Website</label>
        <!--END #form-section-url-->
        </div>
        
		<?php endif; // if ( is_user_logged_in() ) ?>
		
		<!--BEGIN #form-section-comment-->
        <div id="form-section-comment" class="form-section">
        	<textarea name="comment" id="comment" tabindex="4" rows="10" cols="65"></textarea>
        	<p id="allowed-tags">You can use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: <span class="allowed-tags"><?php echo allowed_tags(); ?></span></p>
        <!--END #form-section-comment-->
        </div>
        
        <!--BEGIN #form-section-actions-->
        <div id="form-section-actions" class="form-section">
			<button name="submit" id="submit" type="submit" tabindex="5">Submit Comment</button>
			<?php comment_id_fields(); ?>
        <!--END #form-section-actions-->
        </div>

	<?php do_action( 'comment_form', $post->ID ); // Available action: comment_form ?>
    <!--END #comment-form-->
    </form>
    
	<?php endif; // If registration required and not logged in ?>
<!--END #respond-->
</div>
<?php endif; // ( comments_open() ) ?>