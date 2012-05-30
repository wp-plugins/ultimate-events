<?php
global $wpdb;

$wpdb->show_errors();

$statusTable = $wpdb->prefix . "ultievt_status";

$iconURL = plugin_dir_url( __FILE__ ) . 'images/icon32.png';
?>

<div class="wrap">
	<img class="icon32" src="<?php echo $iconURL ?>" alt="Ultimate Events"/> 
	<h2>
		Ultimate Events - Settings
		<a class="add-new-h2" href=""> Add New Status </a>
	</h2>
	<br/>
	<table class="wp-list-table widefat pages fixed" cellspacing="0">
		<thead>
			<tr>
				<th> Status Name </th>
				<th> Status Shortname </th>
				<th> Actions </th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$statuses = $wpdb->get_results("SELECT * FROM $statusTable WHERE status_name <> '----'");
			?>
			<?php foreach($statuses as $status) { ?>
				<tr>
					<td> <?php echo $status->status_name; ?> </td>
					<td> <?php echo $status->status_shortname; ?> </td>
					<td> </td>
				<tr>
			<?php } ?>
		</tbody>
	</table>
</div>