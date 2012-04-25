<?php 
	global $wpdb;
	
	$eventsTable = $wpdb->prefix . "ultievt_events";
	$attendanceTable = $wpdb->prefix . "ultievt_attendance";
	
	$events = $wpdb->get_results("SELECT * FROM $eventsTable WHERE DATE(event_date) >= DATE(NOW()) ORDER BY event_date");
	$users = $wpdb->get_results("SELECT * FROM $wpdb->users");
?>
<div style='overflow: auto;'>
	<table>
		<thead>
			<tr>
				<th>Event Name</th>
				<th>Event Location</th>
				<?php foreach($users as $user) { ?>
					<th style="writing-mode: tb-rl;">
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
						<td style="text-align: center;">
							<?php  
								$attend = $wpdb->get_row("SELECT * FROM $attendanceTable WHERE user_id = '$user->ID' AND event_id ='$event->event_id'");
								if($attend->attendance === "0") {
									echo '?';
								} elseif($attend->attendance === "1") {
									echo 'Y';
								} elseif($attend->attendance === "2") {
									echo 'N';
								} else {
									echo '-';
								}
							?>
						</td>
					<?php } ?>
				</tr> 
			<?php } ?>
		</tbody>
	</table>
</div> 