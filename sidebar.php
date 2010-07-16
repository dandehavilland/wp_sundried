<?php
/**
* Template: Sidebar.php
*
* @package wp_sundried
* @subpackage Template
*/
?>
<div class="secondary aside">
<?php	/* Widgetized Area */
if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar() ) : ?>

<div class="widget_search widget">
	<?php get_search_form(); ?>
         </div>

<div class="widget_pages widget">
	<h3 class="widget_title">Pages</h3>
	<ul class="xoxo">
		<?php wp_list_pages( 'title_li=' ); ?>
	</ul>
</div>

<div class="widget_categories widget">
	<h3 class="widget_title">Categories</h3>
	<ul class="xoxo">
		<?php wp_list_categories( 'title_li=' ); ?>
	</ul>
</div>

<?php if ( get_tags() ) { ?>
<div class="widget_tags widget">
	<h3 class="widget_title">Tags</h3>
	<?php wp_tag_cloud( 'title_li=&format=list&smallest=13&largest=13&unit=px' ); ?>
</div>
<?php } ?>
<div class="widget_bookmarks widget">
	<h3 class="widget_title">Blogroll</h3>
	<ul class="xoxo">
		<?php wp_list_bookmarks( 'title_li=&categorize=0' ); ?>
	</ul>
</div>

<div class="widget_archives widget">
	<h3 class="widget_title">Archives</h3>
	<ul class="xoxo">
		<?php wp_get_archives( 'type=monthly' ) ?>
	</ul>
</div>

<div class="widget_feeds widget">
	<h3 class="widget_title">RSS Syndication</h3>
	<ul class="xoxo">
		<li><a href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php echo wp_specialchars( get_bloginfo( 'name' ), 1 ) ?> Posts RSS feed" rel="alternate" type="application/rss+xml">All posts</a></li>
		<li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>" title="<?php echo wp_specialchars( bloginfo( 'name' ), 1 ) ?> Comments RSS feed" rel="alternate" type="application/rss+xml">All comments</a></li>
	</ul>
</div>

<div class="widget_meta widget">
	<h3 class="widget_title">Meta</h3>
	<ul class="xoxo">
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<?php wp_meta(); ?>
		<li><a href="http://validator.w3.org/check/referer" title="Validate this page as XHTML 1.0 Transitional">Validate <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
		<li><a href="http://jigsaw.w3.org/css-validator/check/referer" title="Validate this page as CSS level 2.1">Validate <abbr title="Cascading Style Sheets">CSS</abbr></a></li>
	</ul>
</div>
<?php endif; ?>
</div>