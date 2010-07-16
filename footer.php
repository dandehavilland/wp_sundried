<?php
/**
 * Template: Footer.php
 *
 * @package wp_sundried
 * @subpackage Template
 */
?>
		</div><!-- .content_wrapper -->

		<div class="footer">
			<cite class="copyright">&copy; <?php the_time( 'Y' ); ?> <a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a>.</cite>
			<?php wp_footer(); ?>
		</div>
	</div><!-- .container -->
</body>
</html>