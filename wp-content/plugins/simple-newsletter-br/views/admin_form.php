<div class="wrap">
	<form method="post">
		<div id="icon-options-general" class="icon32"></div>
		<h2>Simple Newsletter</h2>
		<?php settings_errors(); ?>

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-2">

				<!-- main content -->
				<div id="post-body-content">

					<div class="meta-box-sortables ui-sortable">

						<div class="postbox">
							<h3><span><?php echo __("Implementation", 'simple-newsletter-br'); ?></span></h3>
							<div class="inside">
								<p><?php echo __("Use the shortcode below where you want to show the subscription form.", 'simple-newsletter-br'); ?></p>
								<code>[simplenewsletter]</code>
								<p><?php echo __("The rest , set in the form here below.", 'simple-newsletter-br'); ?></p>
							</div> <!-- .inside -->

						</div> <!-- .postbox -->

						<div class="postbox">
							<h3><span><?php echo __("Configurations", 'simple-newsletter-br'); ?></span></h3>
							<div class="inside">
								<p></p>
								<table class="form-table" id="configure">
									<tbody>
										<tr valign="top">
											<th scope="row"><?php echo __('Double Opt-in (Confirmation)', 'simple-newsletter-br') ?></th>
											<td>
												<select name="simplenewsletter_dbloptin" class="large-text">
													<option value='1' <?php selected( get_option("simplenewsletter_dbloptin"), 1, true); ?>><?php echo __("Activated", 'simple-newsletter-br'); ?></option>
													<option value='0' <?php selected( get_option("simplenewsletter_dbloptin"), 0, true); ?>><?php echo __("Deactivated", 'simple-newsletter-br'); ?></option>
												</select>
											</td>
										</tr>

										<tr valign="top">
											<th scope="row"><?php echo __('Logo ( Full URL )', 'simple-newsletter-br') ?></th>
											<td>
												<input name="simplenewsletter_logo" id="" type="text" value="<?php echo get_option("simplenewsletter_logo"); ?>" class="large-text" />
											</td>
										</tr>

										<tr valign="top">
											<th scope="row"><?php echo __('Show field "Name" ?', 'simple-newsletter-br') ?></th>
											<td>
												<select name="simplenewsletter_showname" class="large-text">
													<option value='1' <?php selected( get_option("simplenewsletter_showname"), 1, true); ?>><?php echo __('Yes', 'simple-newsletter-br') ?></option>
													<option value='0' <?php selected( get_option("simplenewsletter_showname"), 0, true); ?>><?php echo __('No', 'simple-newsletter-br') ?></option>
												</select>
											</td>
										</tr>
										
										<tr valign="top">
											<th scope="row"><?php echo __('Success Message', 'simple-newsletter-br') ?></th>
											<td>
												<input name="simplenewsletter_successmessage" id="" type="text" value="<?php echo get_option("simplenewsletter_successmessage"); ?>" class="large-text" />
											</td>
										</tr>
										<tr valign="top">
											<th scope="row"><?php echo __('Message to be displayed after confirmation', 'simple-newsletter-br') ?></th>
											<td>
												<input name="simplenewsletter_confirmedmessage" id="" type="text" value="<?php echo get_option("simplenewsletter_confirmedmessage"); ?>" class="large-text" />
											</td>
										</tr>

										<tr valign="top">
											<th scope="row"><?php echo __("Body`s email text", 'simple-newsletter-br') ?></th>
											<td>
												<input name="simplenewsletter_confirmationemail" id="" type="text" value="<?php echo get_option("simplenewsletter_confirmationemail"); ?>" class="large-text" />
											</td>
										</tr>

										<tr valign="top">
											<th scope="row"><?php echo __('Show Message', 'simple-newsletter-br') ?></th>
											<td>
												<select name="simplenewsletter_showon" class="large-text">
													<option value='prepend' <?php selected( get_option("simplenewsletter_showon"), 'prepend', true); ?>><?php echo __('Above subscription form', 'simple-newsletter-br') ?></option>
													<option value='append' <?php selected( get_option("simplenewsletter_showon"), 'append', true); ?>><?php echo __('Below subscription form', 'simple-newsletter-br') ?></option>
													<option value='substitute' <?php selected( get_option("simplenewsletter_showon"), 'substitute', true); ?>><?php echo __('Replace form', 'simple-newsletter-br') ?></option>
												</select>
											</td>
										</tr>
									</tbody>
								</table>
							</div> <!-- .inside -->

						</div> <!-- .postbox -->

						<div class="postbox">
							<h3><span><?php echo __("Doing your own mail template", 'simple-newsletter-br'); ?></span></h3>
							<div class="inside">
								<p><?php echo __("You can make your own html mail template and place the HTML file named 'email_template.html' on root of your theme.", 'simple-newsletter-br'); ?></p>
								<p><?php echo __("Use the bellow markups to show the data:", 'simple-newsletter-br'); ?></p>
								<ol>
									<li><?php echo __('Site Logo:', 'simple-newsletter-br') ?> <code>{logo}</code></li>
									<li><?php echo __('Name of subscriber:', 'simple-newsletter-br') ?> <code>{name}</code></li>
									<li><?php echo __('Email Text ( Configured on form above ):', 'simple-newsletter-br') ?> <code>{text_confirmation}</code></li>
									<li><?php echo __('Confirmation Link:', 'simple-newsletter-br') ?> <code>{button}</code></li>
									<li><?php echo __('Site Link:', 'simple-newsletter-br') ?> <code>{sitelink}</code></li>
									<li><?php echo __('Site Name:', 'simple-newsletter-br') ?> <code>{sitename}</code></li>
								</ol>
							</div> <!-- .inside -->

						</div> <!-- .postbox -->

					</div> <!-- .meta-box-sortables .ui-sortable -->

				</div> <!-- post-body-content -->

				<!-- sidebar -->
				<div id="postbox-container-1" class="postbox-container">

					<div class="meta-box-sortables">

						<div class="postbox">

							<div class="inside">
								<?php submit_button( $text = null, $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
							</div> <!-- .inside -->

						</div> <!-- .postbox -->

					</div> <!-- .meta-box-sortables -->

				</div> <!-- #postbox-container-1 .postbox-container -->

			</div> <!-- #post-body .metabox-holder .columns-2 -->

			<br class="clear">
		</div> <!-- #poststuff -->
	</form>	
</div> <!-- .wrap -->