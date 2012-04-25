<?php
function ultievt_install() {
	global $wpdb;
	
	update_option('ultievt_heading1', 'Event Name');

	$table1name = $wpdb->prefix . "ultievt_events";
	$table2name = $wpdb->prefix . "ultievt_attendance";
	$usersTable = $wpdb->users;
	
	$sql1 = "CREATE TABLE IF NOT EXISTS " . $table1name . "
					(		 
						event_id INT NOT NULL AUTO_INCREMENT,
						event_name VARCHAR(255) NOT NULL DEFAULT '',
						event_date DATETIME NOT NULL,
						event_location VARCHAR(255) NOT NULL DEFAULT 'TBA',
						event_private TINYINT NOT NULL DEFAULT '0',
						event_link TINYINT NOT NULL DEFAULT '0',
						PRIMARY KEY(event_id)
					);";

	$sql2 = "CREATE TABLE IF NOT EXISTS " . $table2name . " 
					(
						user_id BIGINT(20) UNSIGNED,
						event_id INT NOT NULL,
						attendance INT NOT NULL,
						PRIMARY KEY(user_id, event_id),
						FOREIGN KEY(event_id) REFERENCES " . $table1name . "(event_id),
						FOREIGN KEY(user_id) REFERENCES " . $usersTable . "(ID)
					);";
					
	$wpdb->show_errors();
	$wpdb->query($sql1);
	$wpdb->query($sql2);
}

function ultievt_remove() {
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