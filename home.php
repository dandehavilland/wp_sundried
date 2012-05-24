<?php

/**
 * Template: home.php
 *
 * @package wp_sundried
 * @subpackage Template
 */

get_header();


global $homepage_overlays;
$features = get_homepage_page_features();
?>
<div class="features">
<?php

foreach ($features as $key => $meta):

$overlay = $homepage_overlays[$key][$meta['overlay']];
$width = $overlay['width'];
$height = $overlay['height']
?>

  <div class="feature <?=$key?>" style="width:<?=$width?>px; height:<?=$height?>px;">
    <?php if ( wpsc_the_product_thumbnail(null, null, $meta['id']) ) : ?>
  			<a href="<?php echo get_permalink($meta['id']); ?>" rel="<?php echo get_the_title($meta['id']); ?>">
  				<img class="product_image" id="product_image_<?=$meta['id']; ?>" alt="<?php echo get_the_title($meta['id']); ?>" title="<?php echo get_the_title($meta['id']); ?>" src="<?php echo wpsc_the_product_thumbnail($width,$height,$meta['id'],'single'); ?>"/>
        	<img src="<?=$overlay['src']?>" class="overlay" />
          <span class="text" style="<?=$overlay['text_style']?>"><?=$meta['text']?></span>
  			</a>
  	<?php else: ?>
  			<a href="<?php echo get_permalink($meta['id']); ?>">
  			<img class="no-image" id="product_image_<?=$meta['id'] ?>" alt="No Image" title="<?php echo get_the_title($meta['id']); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="<?=$width?>" height="<?=$height?>" />
      	<img src="<?=$overlay['src']?>" class="overlay" />
        <span class="text" style="<?=$overlay['text_style']?>"><?=$meta['text']?></span>
  			</a>
  	<?php endif; ?>
  </div>
<?php endforeach; ?>  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>