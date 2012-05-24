<input type="hidden" name="<?=$this->nonce_name?>" id="<?=$this->meta_key?>_nonce" value="<?=wp_create_nonce($this->nonce_name);?>" />
<p>
	<label for="<?=$this->meta_key?>_title">Title:</label><br />
	<input type="text" name="<?=$this->meta_key?>[title]" id="<?=$this->meta_key?>_title" value="<?=$data['title']?>" class="widefat" />
</p>
<p>
	<label for="<?=$this->meta_key?>_subtitle">Information:</label><br />
	<input type="text" name="<?=$this->meta_key?>[subtitle]" id="<?=$this->meta_key?>_subtitle" value="<?=$data['subtitle']?>" class="widefat" />
</p>