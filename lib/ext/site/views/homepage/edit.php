<?php

?><div class="wrap">
	<div id="icon-index" class="icon32">
		<br />
	</div>
	<h2>Homepage Settings</h2>
	<p class="descripion">
		Choose which pages should appear on the homepage.
	</p>
	<form action="index.php?page=homepage_settings" method="post">
		<input type="hidden" name="<?=$nonce_name?>" value="<?=$nonce_value?>" />
		<table class="form-table">
			<tbody>
				<?php foreach ($positions as $key => $label):?>
				<tr valign="top">
					<th scope="row"><?=$label?></th>
					<td>
							<?php if (have_posts()): ?>
							  <option value="-1" class="em">Do not display.</option>
							<?php while(have_posts()): the_post();?>
								<option value="<?php the_ID(); ?>"<?=($values['home'][$key]['id'] == $post->ID)? 'selected="selected"':''?>><?php the_title(); ?></option>
							<?php endwhile; else: ?>
								<option value="-1" class="em">You have not yet created any products.</option>
							<?php endif; ?>
						</select>
					</td>
					<td>
            <label>Overlay Image</label>
					  <select name="<?=$form_prefix?>[home][<?=$key?>][overlay]">
					    <?php foreach ($homepage_overlays[$key] as $overlay_key => $meta):?>
					    <option value="<?=$overlay_key;?>"<?=($values['home'][$key]['overlay'] == $overlay_key)? 'selected="selected"':''?>><?=$meta['label'];?></option>
					    <?php endforeach; ?>
					  </select>
					</td>
					<td>
					  <label>Overlay Text</label>
					  <input type="text" name="<?=$form_prefix?>[home][<?=$key?>][text]" value="<?=$values['home'][$key]['text']?>" />
					</td>
				</tr>
				<?php rewind_posts(); endforeach; ?>
			</tbody>
		</table>
		
		<p><input class="button" type="submit" value="Update" /></p>
	</form>
</div>