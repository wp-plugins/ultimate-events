<?php 
	global $wpdb;
	
	$eventsTable = $wpdb->prefix . "ultievt_events";
	$attendanceTable = $wpdb->prefix . "ultievt_attendance";
	$statusTable = $wpdb->prefix . "ultievt_status";
	
	$events = $wpdb->get_results("SELECT * FROM $eventsTable WHERE DATE(event_date) >= DATE(NOW()) ORDER BY event_date");
	$users = $wpdb->get_results("SELECT * FROM $wpdb->users");
?>
<div style='overflow: auto;'>
	<table>
		<thead>
			<tr>
				<th>Event Name</th>
				<th> Event Date </th>
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
						<?php if($event->event_cancel) { 
							echo "Cancelled";
						} else { 
							echo date_format(date_create($event->event_date), 'l d/m/y H:i');
						} ?> 
					</td>
					<?php foreach($users as $user) { ?>
						<td style="text-align: center;">
							<?php  
								$attend = $wpdb->get_row("SELECT * FROM $attendanceTable WHERE user_id = '$user->ID' AND event_id ='$event->event_id'");
								$status = $wpdb->get_row("SELECT * FROM $statusTable WHERE status_id='$attend->attendance'");
								if($status) {
									echo $status->status_shorthand;
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