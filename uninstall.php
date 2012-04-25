<?php 
if(defined( 'WP_UNINSTALL_PLUGIN' )) {
	global $wpdb; 

	$table1name = $wpdb->prefix . "ultievt_events";
	$table2name = $wpdb->prefix . "ultievt_attendance";

	$sql1 = "DROP TABLE IF EXISTS " . $table1name;
	$sql2 = "DROP TABLE IF EXISTS " . $table2name;

	$wpdb->show_errors();
	$wpdb->query($sql1);
	$wpdb->query($sql2);
}
?>
