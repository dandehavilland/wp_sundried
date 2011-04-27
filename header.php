<?php
/**
 * Template: Header.php 
 *
 * @package wp_sundried
 * @subpackage Template
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes('xhtml'); ?>>
<head profile="<?php get_profile_uri(); ?>">
	<title><?php bloginfo('name');?> <?php wp_title('|', true); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<link rel="shortcut icon" href="<?php echo WPS_IMAGES_URL . '/favicon.ico'; ?>" />
	<link rel="apple-touch-icon" href="<?php echo WPS_IMAGES_URL . '/iphone.png'; ?>" />

	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen, projection" />
	<!--[if IE]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/assets/styles/styles.ie_all.css" type="text/css" media="screen" charset="utf-8" />
	<![endif]-->
	<!--[if IE 6]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/assets/styles/styles.ie_6.css" type="text/css" media="screen" charset="utf-8" />
	<![endif]-->
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/assets/styles/styles.ie_7.css" type="text/css" media="screen" charset="utf-8" />
	<![endif]-->
	<!--[if IE 8]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/assets/styles/styles.ie_8.css" type="text/css" media="screen" charset="utf-8" />
	<![endif]-->
	<!--[if IE 9]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/assets/styles/styles.ie_9.css" type="text/css" media="screen" charset="utf-8" />
	<![endif]-->

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo( 'rss_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo( 'atom_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>


<body id="<?=body_id();?>" class="<?=body_classes()?>">
	<div class="container">
		
		<div class="header">
			<h1 class="masthead"><a href="/"><span><?= get_bloginfo( 'name' ); ?></span></a></h1>
			<form class="search_form" action="/" method="get" accept-charset="utf-8">
				<input class="search" type="text" name="s" value="<?=get_query_var('s')?>" placeholder="search" />
			</form>
		</div>
		
		<div class="navigation">
			<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
		</div>
		
		<div class="content_wrapper">