<?php
global $wpdb;

$wpdb->show_errors();

$eventsTable = $wpdb->prefix . "ultievt_events";
$attendanceTable = $wpdb->prefix . "ultievt_attendance";

$iconURL = plugin_dir_url( __FILE__ ) . 'images/icon32.png';

if(isset($_POST['ultievt_hidden'])) {
	$name = $_POST['ultievt_evtname'];
	$date = createDate($_POST['ultievt_evtday'], $_POST['ultievt_evtmonth'], 
					$_POST['ultievt_evtyear'], $_POST['ultievt_evthour'], 
					$_POST['ultievt_minute']);
	$location = $_POST['ultievt_evtlocation'];
	if(isset($_POST['ultievt_evtprivate']) && $_POST['ultievt_evtprivate'] == 'yes') {
		$private = 1;
	} else {
		$private = 0;
	}
	
	if(isset($_POST['ultievt_evtlink']) && $_POST['ultievt_evtlink'] == 'yes') {
		$link = 1;
	} else {
		$link = 0;
	}
	
	if(isset($_POST['ultievt_evtcancel']) && $_POST['ultievt_evtcancel'] == 'yes') {
		$cancel = 1;
	} else {
		$cancel = 0;
	}
	
	if($_POST['ultievt_hidden'] == 'add') {
		$wpdb->query("INSERT INTO $eventsTable (event_name, event_date, event_location, event_private, event_link, event_cancel) " . 
						"VALUES ('$name', '$date', '$location', '$private', '$link', '$cancel')"); ?>
		<div class="updated"><p><strong> Event Added! </strong></p></div>
	<?php } else {
		$id = $_POST['ultievt_hidden'];
		$wpdb->query("UPDATE $eventsTable SET event_name='$name', event_date='$date', " .
						"event_location='$location', event_private='$private', event_link='$link', event_cancel='$cancel' WHERE event_id='$id'"); ?>
		<div class="updated"><p><strong> Event Updated! </strong></p></div>
	<?php }
}

function createDate($day, $month, $year, $hour, $minute) {
	$dateString = $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute;
	return $dateString;
}

$events = $wpdb->get_results("SELECT * FROM $eventsTable WHERE DATE(event_date) >= DATE(NOW()) ORDER BY event_date");
?>

<div class="wrap">
	<img class="icon32" src="<?php echo $iconURL ?>" alt="Ultimate Events"/> 
	<h2>
		Ultimate Events 
		<a class="add-new-h2" href="admin.php?page=ultimate_events_menu&action=add"> Add New Event </a>
	</h2>
	<br/>
	<table class="wp-list-table widefat pages fixed" cellspacing="0">
		<thead>
			<tr>
				<th> Event Name </th>
				<th> Event Date </th>
				<th> Event Location </th>
				<th> Private Event </th>
				<th> Event Cancelled </th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($events as $event) { ?>
			<tr>
				<td style="height:30px"> <?php echo $event->event_name ?> </td>
				<td style="height:30px"> <?php echo date_format(date_create($event->event_date), 'd/m/y H:i') ?> </td>
				<td style="height:30px"> 
					<?php if($event->event_link) { ?>
						<a href="<?php echo $event->event_location ?>"> Link to Location </a>
					<?php } else { ?>
						<?php echo $event->event_location ?>
					<?php } ?> 
				</td>
				<td style="height:30px"> 
					<?php if($event->event_private) {
						echo "Yes";
					} else { 
						echo "No";
					} ?>
				</td>
				<td style="height:30px"> 
					<?php if($event->event_cancel) {
						echo "Yes";
					} else { 
						echo "No";
					} ?>
				</td>
				<td style="height:30px">
					<a class="button-secondary" 
						href="admin.php?page=ultimate_events_menu&action=edit&event=<?php echo $event->event_id ?>"> 
						Edit Event </a>
					<a class="button-secondary" 
						href="admin.php?page=ultimate_events_menu&action=copy&event=<?php echo $event->event_id ?>"> 
						Copy Event </a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<?php if(isset($_GET['action'])) { ?>
		<br/> <hr/> <br/>
		<form method="post" name="Event Form" action="admin.php?page=ultimate_events_menu">
		<?php if($_GET['action'] == "add") { ?>
			<h3> Add Event </h3> 
			<input type="hidden" name="ultievt_hidden" value="add"/>
			<?php eventForm('', '', '', 0, 0, 0); ?> <br/>
			<input class="button-primary" type="submit" value="Submit Event" />
		<?php } elseif ($_GET['action'] == "edit") { ?>
			<h3> Editing Event </h3> 
			<input type="hidden" name="ultievt_hidden" value="<?php echo $_GET['event'] ?>"/>
			<?php
				$id = $_GET['event'];
				$event = $wpdb->get_row("SELECT * FROM $eventsTable WHERE event_id=$id");
				eventForm($event->event_name, $event->event_date, $event->event_location, $event->event_private, $event->event_link, $event->event_cancel); 
			?> <br/>
			<input class="button-primary" type="submit" value="Update Event" />
		<?php } elseif ($_GET['action'] == "copy") { ?>
			<h3> Add Event </h3> 
			<input type="hidden" name="ultievt_hidden" value="add"/>
			<?php
				$id = $_GET['event'];
				$event = $wpdb->get_row("SELECT * FROM $eventsTable WHERE event_id=$id");
				eventForm($event->event_name, $event->event_date, $event->event_location, $event->event_private, $event->event_link, $event->event_cancel);
			?> <br/>
			<input class="button-primary" type="submit" value="Submit Event" />
		<?php } ?> 
		</form>
	<?php } ?>
</div>

<?php function eventForm($name, $date, $location, $private, $link, $cancel) { 
	$dd = date_create($date);
	$day = date_format($dd, 'd');
	$month = date_format($dd, 'm');
	$year = date_format($dd, 'Y');
	$hour = date_format($dd, 'H');
	$min = date_format($dd, 'i');
?>
	<table>
		<tr>
			<td style="height:40px"><label for="ultievt_evtname">Event Name:</label></td>
			<td style="height:40px"><input id="ultievt_evtname" type="text" size="30" name="ultievt_evtname" value="<?php echo $name ?>"/></td>
		</tr>
		<tr>
			<td style="height:40px"><label for="ultievt_evtday">Event Date:</label></td>
			<td style="height:40px">
				<input id="ultievt_evtday" maxlength="2" size="4" type="text" name="ultievt_evtday" value="<?php echo $day ?>"/> / 
				<input maxlength="2" size="4" type="text" name="ultievt_evtmonth" value="<?php echo $month ?>"/> / 
				<input maxlength="4" size="4" type="text" name="ultievt_evtyear" value="<?php echo $year ?>"/> 
			</td>
		</tr>
		<tr>
			<td style="height:40px"><label for="ultievt_evthour">Event Time:</label></td>
			<td style="height:40px">
				<input maxlength="2" size="2" type="text" name="ultievt_evthour" value="<?php echo $hour ?>"/> <strong> : </strong>
				<input maxlength="2" size="2" type="text" name="ultievt_minute" value="<?php echo $min ?>"/> 
			</td>
		</tr>	
		<tr>
			<td style="height:40px"><label for="ultievt_evtlocation">Event Location:</label></td>
			<td style="height:40px"><input id="ultievt_evtlocation" type="text" size="30" name="ultievt_evtlocation" value='<?php echo $location ?>'/></td>
			<td style="height:40px"><label for="ultievt_evtlocation">Is Link:</label></td>
			<td style="height:40px"><input type="checkbox" name="ultievt_evtlink" value="yes" <?php if($link) { ?> checked="yes" <?php } ?> /></td>			
		</tr>
		<tr>
			<td style="height:40px"><label for="ultievt_evtprivate">Private Event:</label></td>
			<td style="height:40px"><input id="ultievt_evtprivate" type="checkbox" name="ultievt_evtprivate" value="yes" <?php if($private) { ?> checked="yes" <?php } ?>/></td>
		</tr>
		<tr>
			<td style="height:40px"><label for="ultievt_evtcancel">Event Cancelled:</label></td>
			<td style="height:40px"><input id="ultievt_evtcancel" type="checkbox" name="ultievt_evtcancel" value="yes" <?php if($cancel) { ?> checked="yes" <?php } ?>/></td>
		</tr>
	</table>
<?php } ?>