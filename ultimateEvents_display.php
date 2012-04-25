<?php
global $user_ID, $wpdb;

$loggedin = is_user_logged_in();

if($loggedin) {
	get_currentuserinfo();
}

$eventsTable = $wpdb->prefix . "ultievt_events";
$attendanceTable = $wpdb->prefix . "ultievt_attendance";
$events = $wpdb->get_results("SELECT * FROM $eventsTable WHERE DATE(event_date) >= DATE(NOW()) ORDER BY event_date");

if($_POST['ultievt_hidden'] == 'Y') {
	foreach($events as $event) {
		$event_id = $event->event_id;
		$attendance = $_POST['attendance_' . $event->event_id];
		$attend = $wpdb->get_row("SELECT * FROM $attendanceTable WHERE user_id = $user_ID AND event_id = $event_id");
		if($attend != NULL) {
			$wpdb->query("UPDATE $attendanceTable SET attendance = $attendance WHERE user_id = $user_ID AND event_id = $event_id"); 
		} else {
			$wpdb->query("INSERT INTO $attendanceTable VALUES ($user_ID, $event_id, $attendance)");
		}
	} ?>
	<div class="updated"><p><strong><?php _e('Attendance Updated!'); ?></strong></p></div>
<?php } ?>

<?php if($loggedin) { ?>
	<form method="post" name="Update Status" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<?php } ?>
<table>
	<tr>
		<th> Event Name </th>
		<th> Event Date </th>
		<th> Event Location </th>
		<?php if($loggedin) { ?> <th> Attendance </th> <?php } ?> 
	</tr>
<?php foreach($events as $event) { 
	if(!$event->event_private || $loggedin) { ?>
		<tr>
			<td> <?php echo $event->event_name ?> </td>
			<td> <?php echo date_format(date_create($event->event_date), 'd/m/y H:i') ?> </td>
			<td> 
				<?php if($event->event_link) { ?>
					<a href="<?php echo $event->event_location ?>"> Link to Location </a>
				<?php } else { ?>
					<?php echo $event->event_location ?>
				<?php } ?> 
			</td>
			<?php if($loggedin) { 
				$event_id = $event->event_id;
				$attend = $wpdb->get_row("SELECT * FROM $attendanceTable WHERE user_id = $user_ID AND event_id = $event_id"); ?> 
				<td> 
					<select name="attendance_<?php echo $event->event_id ?>"> 
						<option value="-1"> ---- </option>
						<option value="0" <?php if($attend->attendance === "0") {?> selected="yes" <?php } ?> >Don't Know</option> 
						<option value="1" <?php if($attend->attendance === "1") {?> selected="yes" <?php } ?> >Going</option> 
						<option value="2" <?php if($attend->attendance === "2") {?> selected="yes" <?php } ?> >Not Going</option> 
					</select> 
				</td> 
			<?php } ?> 	
		</tr>
	<?php } 
} ?>
</table>
<?php if($loggedin) { ?>
	<input type="hidden" name="ultievt_hidden" value="Y"/>
	<input type="submit" value="Update" />
	</form>
<?php } ?>
