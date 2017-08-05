<?php $options = $this->helper->getClickAndPickOptions();?>

<tr id="click-and-pick">
	<th><?php echo !empty($options['title']) ?
$options['title'] :
\Click_And_Pick\Click_And_Pick::NAME ?></th>
	<td>

		<?php $branches = $this->helper->get_current_branches()?>

		<?php if (!empty($branches)): ?>
			<ul id="click-n-pick-branches">

				<?php foreach ($branches as $branch): ?>

				<div class="branch-content-container">

				<li class="click-n-pick-list">
					<input type="radio" id="click-n-pick-radio-<?php echo $branch->ID ?>"
					       class="click-n-pick-branch-radio" name="click_n_pick_branch"
					       value="<?php echo $branch->ID ?>"/> <label
						for=""> &nbsp; <?php echo $branch->post_title ?></label>
				</li>

				<li class="branch-date">
					<input id="clicktimepicker-<?php echo $branch->ID ?>"
					       name="click_n_pick_picked_time_<?php echo $branch->ID ?>"
					       class="clicktime-pick-class"
					       placeholder="<?php _e('Choose Pickup Date', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN)?>"
					       type="text"/>
				</li>


				<?php $note = get_post_meta($branch->ID, '_clicknpick_branches_notes', true);?>
				<?php $latitude = get_post_meta($branch->ID, '_clicknpick_branches_location_latitude', true);?>
				<?php $longtitude = get_post_meta($branch->ID, '_clicknpick_branches_location_longitude', true);?>
				<?php $show_map = get_post_meta($branch->ID, '_clicknpick_branches_location_show', true);?>
				<li>
					<ul>
						<?php if (!empty($note)): ?>
							<li class="click-n-pick-span"><span><?php echo $note ?></span></li>
						<?php endif;?>

						<?php if (!empty($latitude) && !empty($longtitude) && $show_map == "on"): ?>

							<li class="click-n-pick-span">
								<a href="#" id="opener-<?php echo $branch->ID ?>">
									<?php _e('Our location on map', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN) ?>
								</a>
							</li>

							<div class="modal-header">
								<div class="dialog" id="map-<?php echo $branch->ID ?>-content"
								     style="width:500px !important; height:500px !important;display: none"></div>
							</div>


						<?php endif;?>
					</ul>
				</li>
					<?php
						$vacation_list = $this->helper->get_vacations_list($branch->ID);
					?>

					<script>
						var disabledDatesList_<?php echo $branch->ID ?> = ['<?php echo $vacation_list ?>'];

						jQuery('document').ready(function($) {

							<?php if (!empty($latitude) && !empty($longtitude) && $show_map == "on"): ?>

							// google map
							var map = new GMaps({
								div: '#map-<?php echo $branch->ID ?>-content',
								lat: <?php echo $latitude ?>,
								lng: <?php echo $longtitude ?>,
								width: 500,
								height: 500
							});

							// add the marker on the map
							map.addMarker({
								lat: <?php echo $latitude ?>,
								lng: <?php echo $longtitude ?>
							});


							$("#map-<?php echo $branch->ID ?>-content").dialog({
								autoOpen: false,
								zoom: 12,
								width: 500,
								height: 500,
								open: function (event, ui) {
									map.refresh();               // important to resize the map after the dialog is triggered
									map.setCenter(<?php echo $latitude ?>, <?php echo $longtitude ?>);
								}
							});

							$("#opener-<?php echo $branch->ID ?>").click(function (e) {
								e.preventDefault();
								$("#map-<?php echo $branch->ID ?>-content").dialog("open");
							});

							<?php endif;?>

							var branch_id = '<?php echo $branch->ID ?>';

							// default is today only
							$('#clicktimepicker-<?php echo $branch->ID ?>').datetimepicker({ minDate: 0 });

							$('#clicktimepicker-<?php echo $branch->ID ?>').datetimepicker({
								<?php if (!empty($options['datetime_picker_language'])): ?>
								lang: '<?php echo $options['datetime_picker_language'] ?>',
								<?php endif;?>
								<?php $date_format = get_option('date_format') ?>
								<?php $time_format = get_option('time_format') ?>
                                <?php if(!empty($date_format) && !empty($time_format)): ?>
								format: "<?php echo get_option('date_format') ?> <?php echo get_option('time_format') ?>",
                                <?php else: ?>
                                format: 'm/d/Y H:i',
                                <?php endif; ?>
                                yearStart: <?php echo date("Y") ?>,
                                <?php if($options['allow_next_year'] == 'yes'): ?>
                                yearEnd: <?php echo date("Y", strtotime('+1 year')) ?>,
                                <?php else: ?>
                                yearEnd: <?php echo date("Y") ?>,
                                <?php endif; ?>
                                scrollMonth: false,
								step: 5,
								<?php if (!empty($options['theme'])): ?>
								theme: '<?php echo $options['theme'] ?>',
								<?php endif;?>
								timepicker: true,
								formatTime: "<?php echo empty($options['time_format']) ? 'g:i A' : $options['time_format'] ?>",
								<?php if (!empty($vacation_list)): ?>
								disabledDates: disabledDatesList_<?php echo $branch->ID ?>,
								<?php endif;?>

								<?php
								$timeFormat = empty($options['time_format']) ? 'g:i A' : $options['time_format'];
								$dateFormat = 'm/d/Y';
								$minTime = $this->helper->get_branch_meta($branch->ID, '_clicknpick_branch_from');
								$maxTime = $this->helper->get_branch_meta($branch->ID, '_clicknpick_branch_to');
								$delay   = $this->helper->get_branch_meta($branch->ID, "_clicknpick_branches_order_pickup_delay");
								$minDate = $this->helper->get_branch_meta($branch->ID, '_clicknpick_branch_working_day_from');
							    $maxDate = $this->helper->get_branch_meta($branch->ID, '_clicknpick_branch_working_day_to');

								// let's get the working hours
								if(!empty($delay)) {
									if( !empty($minDate) && !empty($minTime) ) {
										$formatDate = $minDate . ' ' . $minTime;
									} elseif( empty($minDate) && !empty($minTime)) {
										$formatDate = $minTime;
									} elseif( !empty($minDate) && empty($minTime)) {
										$formatDate = $minDate;
									} else {
										$formatDate = null;
									}
									$date = date_create($formatDate)->modify("+".$delay." hours");
									$minTime = $date->format($timeFormat);
									$minDate = $date->format($dateFormat);
								}

								?>
								<?php if ($minTime): ?>
								defaultTime: "<?php echo date($timeFormat, strtotime($minTime)) ?>",
								minTime: "<?php echo date($timeFormat, strtotime($minTime)) ?>",
								<?php else: ?>
								minTime: 0,
								<?php endif; ?>

								<?php if ($maxTime): ?>
								maxTime: "<?php echo date($timeFormat, strtotime($maxTime)) ?>",
								<?php endif;?>


								<?php if ($minDate): ?>
								minDate: "<?php echo $minDate ?>",
								<?php endif;?>
								<?php if ($maxDate): ?>
								maxDate: "<?php echo $maxDate ?>",
								<?php endif;?>
								formatDate: "<?php echo $dateFormat; ?>",

								onChangeDateTime: function(ct, input, event) {
									var currentDate       = new Date(input.val()).toDateString();
									$.each(disabledDatesList_<?php echo $branch->ID ?>, function(key, value) {
										var disableDate = new Date(value).toDateString();
										if (disableDate == currentDate) {
											$(input).val('');
										}
									});
								},
								onShow:function(ct, input){
									jQuery('.clicktime-pick-class').val('');
									jQuery(input).parent().prev().find('.click-n-pick-branch-radio').prop('checked', true);
								  	var alerted = sessionStorage.getItem('alerted' + branch_id) || '';
							        if (alerted != 'yes') {
						        	<?php if( !empty($delay) ): ?>
							         	alert("Your pickup time will be delayed for this branch for " + <?php echo $delay ?> + " hours");
							         <?php endif; ?>
							         sessionStorage.setItem('alerted' + branch_id,'yes');
							        }
								}
							});

						});
					</script>

					</div> <!-- end the container for the branch -->
				<?php endforeach;?>
			</ul>
		<?php else: ?>
			<ul id="click-n-pick-branches">
				<li><?php _e('No branches found', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN)?></li>
			</ul>
		<?php endif;?>

	</td>
</tr>

