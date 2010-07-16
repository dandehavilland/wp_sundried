<?php
/**
 * Template: Header.php 
 *
 * @package wp_sundried
 * @subpackage Template
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes('xhtml'); ?>>
<head profile="<?php get_profile_uri(); ?>">
	<title><?php bloginfo('name');?> <?php wp_title('|', true); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<link rel="shortcut icon" href="<?php echo IMAGES . '/favicon.ico'; ?>" />
	<link rel="apple-touch-icon" href="<?php echo IMAGES . '/iphone.png'; ?>" />

	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="<?php echo CSS . '/print.css'; ?>" type="text/css" media="print" />

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo( 'rss_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo( 'atom_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>

<body class="<?php echo body_classes(); ?>">
	<div class="container">
		
		<div class="header">
			<h1 class="masthead"><a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ) ?></a></h1>
			<p class="site_description"><?php bloginfo( 'description' ) ?></p>
		</div>

        <?php wp_page_menu( 'show_home=1' ); ?>

		<div class="content_wrapper">