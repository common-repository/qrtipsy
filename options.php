<?php
	$options = get_option('qrtipsy_options');
?>
<div class="wrap qr_admin">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2 style="font-family: Lobster;">QR Tipsy Dashboard</h2>
	<br />
	<div id="qr_main" class="qr_tabs">
		<ul>
			<li><a href="#qr_main_settings">Settings</a></li>
			<li><a href="#qr_main_docs">Documentation</a></li>
		</ul>
		
		<div id="qr_main_settings">	
			<div id="qr_main_general" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
				<div class="qr_buttons_bar" id="qr_main_buttons_bar">
					<div class="qr_messages">
						<img src="<?php echo $this->pluginUrl . 'images/spinner.gif' ?>" id="qr_loading_spinner" />
						<span id="qr_message_text"></span>
					</div>
					<a class="qr_button" data-hide="qr_main_docs" rel="save" id="qr_main_save" data-help="Save current Configuration">SAVE</a>
					<br>
				</div>
				<br />
				<form id="qr_global_options" method="post">
					<table class="">
						<tbody>
							<tr>
								<td rowspan="10" class="qr_field_skin">
									<label for="qr_global_skin" id="qr_global_skin_label" data-help="Select a Qr Tooltip Skin">Select Skin</label>
									<div class="qr_radio ui-buttonset">
										<input type="radio" id="qr_global_skin0" name="skin" <?php if($options->skin == "black") echo 'checked'; ?> value="black" />
										<label for="qr_global_skin0">Black</label>
										<input type="radio" id="qr_global_skin1" name="skin" <?php if($options->skin == "red") echo 'checked'; ?> value="red" />
										<label for="qr_global_skin1">Red</label>
										<input type="radio" id="qr_global_skin2" name="skin" <?php if($options->skin == "green") echo 'checked'; ?> value="green" />
										<label for="qr_global_skin2">Green</label>
										<input type="radio" id="qr_global_skin3" name="skin" <?php if($options->skin == "blue") echo 'checked'; ?> value="blue" />
										<label for="qr_global_skin3">Blue</label>
										<input type="radio" id="qr_global_skin4" name="skin" <?php if($options->skin == "white") echo 'checked'; ?> value="white" />
										<label for="qr_global_skin4">White</label>
										<input type="radio" id="qr_global_skin5" name="skin" <?php if($options->skin == "yellow") echo 'checked'; ?> value="yellow" />
										<label for="qr_global_skin5">Yellow</label>
									</div>
									<div id="qr_global_skin_preview" align="center">
										<img src="<?php echo $this->pluginUrl . 'images/qr_demo_black.png'; ?>" id="qr_skin_black" <?php if($options->skin == "black") echo 'class="qr_active"'; ?> />
										<img src="<?php echo $this->pluginUrl . 'images/qr_demo_red.png'; ?>" id="qr_skin_red" <?php if($options->skin == "red") echo 'class="qr_active"'; ?> />
										<img src="<?php echo $this->pluginUrl . 'images/qr_demo_green.png'; ?>" id="qr_skin_green" <?php if($options->skin == "green") echo 'class="qr_active"'; ?> />
										<img src="<?php echo $this->pluginUrl . 'images/qr_demo_blue.png'; ?>" id="qr_skin_blue" <?php if($options->skin == "blue") echo 'class="qr_active"'; ?> />
										<img src="<?php echo $this->pluginUrl . 'images/qr_demo_white.png'; ?>" id="qr_skin_white" <?php if($options->skin == "white") echo 'class="qr_active"'; ?> />
										<img src="<?php echo $this->pluginUrl . 'images/qr_demo_yellow.png'; ?>"  id="qr_skin_yellow" <?php if($options->skin == "yellow") echo 'class="qr_active"'; ?> />
									</div>
								</td>
								<td colspan="2" class="qr_field_skin_filler">&nbsp;</td>
							</tr>
							<tr>
								<td class="qr_field_number">
									<label for="qr_global_size" data-help="Size of the Qr Code">Size</label>
								</td>
								<td class="qr_field_skin">
									<input type="hidden" id="qr_global_size" class="qr_global_size" name="size" value="<?php echo $options->size; ?>" />
									<div id="qr_size_slider"></div>
									<!-- Displaying Slider Value -->
									<input type="text" id="qr_size_value" style="border: 0;" size="5" readonly value="<?php echo $options->size; ?>" />
								</td>
							</tr>
							<tr>
								<td class="qr_field_number">
									<label for="qr_global_timeout" data-help="Time for which tooltip is Visible">Timeout</label>
								</td>
								<td class="qr_field_skin">
									<input type="hidden" id="qr_global_timeout" class="qr_global_timeout" name="timeout" value="<?php echo $options->timeout; ?>" />
									<div id="qr_timeout_slider"></div>
									<!-- Displaying Slider Value -->
									<input type="text" id="qr_timeout_value" style="border: 0;" size="5" readonly value="<?php echo $options->timeout; ?>" />
								</td>
							</tr>
							<tr>
								<td><label data-help="Randomizr Options (BETA)">Randomize?</label></td>
								<td>
									<div class="qr_radio">
									<input type="radio" name="randomize" id="qr_global_randomize0" value="enabled" <?php if($options->randomize == 'enabled') echo 'checked' ?> >
									<label for="qr_global_randomize0" >Yes</label>
									<input type="radio" name="randomize" id="qr_global_randomize1" value="disabled" <?php if($options->randomize == 'disabled') echo 'checked' ?> >
									<label for="qr_global_randomize1">No</label>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<div id="qr_main_docs">
			<?php include $this->pluginPath . 'docs/docs.html'; ?>
		</div>
	</div>
</div>