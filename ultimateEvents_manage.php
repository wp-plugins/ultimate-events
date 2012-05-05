<?php 
	global $wpdb;
	
	$iconURL = plugin_dir_url( __FILE__ ) . 'images/icon32.png';
	
	$eventsTable = $wpdb->prefix . "ultievt_events";
	$attendanceTable = $wpdb->prefix . "ultievt_attendance";
	
	$events = $wpdb->get_results("SELECT * FROM $eventsTable WHERE DATE(event_date) >= DATE(NOW()) ORDER BY event_date");
	$users = $wpdb->get_results("SELECT * FROM $wpdb->users");
	
	if($_POST['ultievt_hidden'] == 'yes') {
		foreach($events as $event) {
			foreach($users as $user) {
				$attendance = $_POST['attendance_' . $event->event_id . '_' . $user->ID];
				$attend = $wpdb->get_row("SELECT * FROM $attendanceTable WHERE user_id = '$user->ID' AND event_id = '$event->event_id'");
				if($attend != NULL) {
					$wpdb->query("UPDATE $attendanceTable SET attendance = $attendance WHERE user_id = '$user->ID' AND event_id = '$event->event_id'"); 
				} else {
					$wpdb->query("INSERT INTO $attendanceTable VALUES ('$user->ID', '$event->event_id', $attendance)");
				}
			}
		} ?>		
		<div class="updated"><p><strong><?php _e('Attendance Updated!'); ?></strong></p></div>
	<?php }
?>
<div class="wrap">
	<form method="post" name="Update Status" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<img class="icon32" src="<?php echo $iconURL ?>" alt="Ultimate Events"/> 
		<h2>
			Ultimate Events - Manage Attendence
			<input class="add-new-h2" style="color: #21759B;" type="submit" value="Update" /> 
		</h2>
		<br/>
		<div style='overflow: auto;'>
			<table class="wp-list-table widefat pages fixed" cellspacing="0">
				<thead>
					<tr>
						<th>Event Name</th>
						<th>Event Location</th>
						<?php foreach($users as $user) { ?>
							<th>
								<?php echo $user->display_name ?>
							</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($events as $event) { ?>
						<tr>
							<td><?php echo $event->event_name ?></td>
							<td> 
								<?php if($event->event_link) { ?>
									<a href="<?php echo $event->event_location ?>"> Link to Location </a>
								<?php } else { ?>
									<?php echo $event->event_location ?>
								<?php } ?> 
							</td>
							<?php foreach($users as $user) { ?>
								<td>
									<?php  
										$attend = $wpdb->get_row("SELECT * FROM $attendanceTable WHERE user_id = '$user->ID' AND event_id ='$event->event_id'");
									?>
									<select name="attendance_<?php echo $event->event_id ?>_<?php echo $user->ID ?>"> 
										<option value="-1">-</option>
										<option value="0" <?php if($attend->attendance === "0") {?> selected="yes" <?php } ?> >?</option> 
										<option value="1" <?php if($attend->attendance === "1") {?> selected="yes" <?php } ?> >Y</option> 
										<option value="2" <?php if($attend->attendance === "2") {?> selected="yes" <?php } ?> >N</option> 
									</select> 
								</td>
							<?php } ?>
						</tr> 
					<?php } ?>
				</tbody>
			</table>
		</div>
		<input type="hidden" value="yes" name="ultievt_hidden"/>
	</form>
</div>