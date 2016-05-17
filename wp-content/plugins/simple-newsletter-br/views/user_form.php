<div class="simplenewsletter" data-showon='<?php echo get_option('simplenewsletter_showon'); ?>'>
	<?php $formID = uniqid('form_simplenewsletter-'); ?>
	<form method='POST' id='submit_simplenewsletter' class='<?php echo $formID ?>'>
		<?php 
		if(get_option('simplenewsletter_showname') == 1)
		{
			?>
			<fieldset class='simplenewsleter-field simplenewsleter-field-name'>
				<input name='simplenewsletter[name]' type='text' placeholder='<?php echo __("Name", 'simple-newsletter-br') ?>'/>
			</fieldset>
			<?php 
		} ?>
		<fieldset class='simplenewsleter-field simplenewsleter-field-email'>
			<input name='simplenewsletter[email]' type='email' placeholder='<?php echo __("Email", 'simple-newsletter-br') ?>' />
		</fieldset>
		<input type="submit" value="<?php echo __("Send", 'simple-newsletter-br') ?>" class='simplenewsleter-field-submit' />
	</form>
	<div class="simplenewsletter_spinner" style="display:none;">
		<img src="<?php echo plugins_url('../images/loading_spinner.gif', __FILE__) ?>" style="margin-left:45%;">
	</div>
</div>
<script>
	initSimpleNewsletter('.<?php echo $formID; ?>');
</script>