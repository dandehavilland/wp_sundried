<?=$before_widget;?>
<?php if ($title):?>
	<div class="title_row">
		<?=$before_title?>
		<?=$title?>
		<?=$after_title?>
		<?php if (isset($this->wq) && $this->wq->have_posts()):?>
		<a class="more" href="/category/<?=$this->query_params['category_name']?>">
			<span>More&hellip;</span>
		</a>
		<?php endif; ?>
	</div>
<?php endif;?>