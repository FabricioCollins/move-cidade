<?php
$emailList = new controllerNewsletter();
?>
<div class="wrap">	
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php printf(__("Last %d subscriptions", 'simple-newsletter-br'),$emailList->limit) ?></h2>

	<div class="tablenav top">
		<div class="alignleft actions bulkactions">
			
				<label for="bulk-action-selector-top" class="screen-reader-text"><?php echo __('Export', 'simple-newsletter-br'); ?></label>
				<select name="action" id="exportMethod">
					<option value="-1"><?php echo __('Export', 'simple-newsletter-br'); ?></option>
					<option value="?sn_export_method=EXPORT_ALL"><?php echo __('All', 'simple-newsletter-br'); ?></option>
					<option value="?sn_export_method=EXPORT_CONFIRMED"><?php echo __('Confirmed', 'simple-newsletter-br'); ?></option>
				</select>
				<input type="submit" id="doExport" class="button" value="<?php echo __('Download', 'simple-newsletter-br'); ?>">
			
		</div>
		<br class="clear">
	</div>
	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<table class="widefat">
					<thead>
						<tr>
							<th>#</th>
							<th><?php echo __("Name", 'simple-newsletter-br'); ?></th>
							<th><?php echo __("Email", 'simple-newsletter-br'); ?></th>
							<th><?php echo __("Subscription date", 'simple-newsletter-br'); ?></th>
							<th><?php echo __("Confirmed", 'simple-newsletter-br'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$page = (isset($_GET['paged']))?$_GET['paged']:0;
						$subscribers = $emailList->get_subscribers('all', $page);

						foreach ( $subscribers as $subscriber) {
							?>
							<tr>
								<td><?php echo $subscriber['id'] ?></td>
								<td><?php echo $subscriber['name'] ?></td>
								<td><?php echo $subscriber['email'] ?></td>
								<td><?php echo date('d/m/Y H:i:s', strtotime($subscriber['created'])); ?></td>
								<td><?php echo ($subscriber['confirmed'] == 0)?'<div class="dashicons-before dashicons-no"><br/></div>':'<div class="dashicons-before dashicons-yes"><br/></div>'; ?></td>
							</tr>
							<?php
						}

						if(empty($subscribers))
						{
							?>
							<tr>
								<td colspan="5"><center><?php __("No one subscriber found", 'simple-newsletter-br'); ?></center></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>

			</div> <!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">					
					<div class="postbox">
						<h3 class='hndle ui-sortable-handle'><span><?php echo __("Status", 'simple-newsletter-br'); ?></span></h3>
						<div class="inside">
							<div>
								<?php $total = $emailList->count();?>
								<p><b><?php echo __("Confirmed", 'simple-newsletter-br'); ?>: </b><?php echo number_format($total[0]['qty_confirmed'], 0, '', '.'); ?></p>
								<p><b><?php echo __("Not confirmed", 'simple-newsletter-br'); ?>: </b><?php echo number_format($total[0]['qty_unconfirmed'], 0, '', '.'); ?></p>
								<hr/>
								<p><b><?php echo __("Today", 'simple-newsletter-br'); ?>: </b><?php echo number_format($total[0]['today'], 0, '', '.'); ?></p>
								<p><b><?php echo __("Yesterday", 'simple-newsletter-br'); ?>: </b><?php echo number_format($total[0]['yesterday'], 0, '', '.'); ?></p>
								<p><b><?php echo __("Last Week", 'simple-newsletter-br'); ?>: </b><?php echo number_format($total[0]['last_week'], 0, '', '.'); ?></p>
								<p><b><?php echo __("All Time", 'simple-newsletter-br'); ?>: </b><?php echo number_format(($total[0]['qty_confirmed']+$total[0]['qty_unconfirmed']), 0, '', '.'); ?></p>
							</div>
						</div> <!-- .inside -->

					</div> <!-- .postbox -->

				</div> <!-- .meta-box-sortables -->

			</div> <!-- #postbox-container-1 .postbox-container -->

		</div> <!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div> <!-- #poststuff -->

</div> <!-- .wrap -->