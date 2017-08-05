<div class="wcas-progress-bar-box">
	<div class="wcas-progress-bar-background" id="wcas-progress-bar-background-<?php echo $post->ID; ?>">
		<div class="wcas-progress-bar" id="wcas-progress-bar-<?php echo $post->ID; ?>"></div>
	</div>
	<?php if(!$hide_sales_progress_bar_label): ?>
	<div class="wcas-progress-label">
		<?php echo sprintf(__('%d / %d', 'woocommerce-pre-sale'), $sales_data['total_sales'],$sales_data['sales_limit'][$today]); ?>
	</div>
	<?php endif; ?>
</div>
<script>
jQuery("#wcas-progress-bar-background-<?php echo $post->ID; ?>").css('background', '<?php echo $sales_progress_bar_background_color; ?>');
jQuery("#wcas-progress-bar-<?php echo $post->ID; ?>").css('background', '<?php echo $sales_progress_bar_color; ?>');
jQuery("#wcas-progress-bar-<?php echo $post->ID; ?>").css('width', '<?php echo $progress_value; ?>%');
</script>