<?php
/**
 * Template: Footer.php
 *
 * @package wp_sundried
 * @subpackage Template
 */
?>
    <div class="foot tag_container">
      <div class="mailer_container">
        <form action="/" method="post" accept-charset="utf-8" class="mailer_form">
          <label for="mailer_email_input">Join our mailing list</label>
          <input id="mailer_email_input" class="email" type="text" name="email" value="" />
          <input class="submit" type="submit" name="submit" value="Submit" />
        </form>
      </div>
    </div>
    
		</div><!-- .content_wrapper -->
    
		<div class="footer">
		  <?php wp_nav_menu(array('theme_location' => 'footer')); ?>
			<!-- <cite class="copyright">&copy; <?php the_time( 'Y' ); ?> <a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a>.</cite> -->
			<?php wp_footer(); ?>
		</div>
	</div><!-- .container -->
</body>
</html>