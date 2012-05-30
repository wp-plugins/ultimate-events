<?php
function ultievt_install() {
	global $wpdb, $version;
	
	$table1name = $wpdb->prefix . "ultievt_events";
	$table2name = $wpdb->prefix . "ultievt_status";
	$table3name = $wpdb->prefix . "ultievt_attendance";
	$usersTable = $wpdb->users;
	$current_version = get_option("ultievt_version");
	
	if($current_version != $version) {
		$sql1 = "CREATE TABLE $table1name (		 
							event_id INT NOT NULL AUTO_INCREMENT,
							event_name VARCHAR(255) NOT NULL DEFAULT '',
							event_date DATETIME NOT NULL,
							event_location VARCHAR(255) NOT NULL DEFAULT 'TBA',
							event_private TINYINT NOT NULL DEFAULT '0',
							event_link TINYINT NOT NULL DEFAULT '0',
							event_cancel TINYINT NOT NULL DEFAULT '0',
							PRIMARY KEY  (event_id)
						);";

		$sql2 = "CREATE TABLE IF NOT EXISTS $table2name (
							status_id INT NOT NULL AUTO_INCREMENT,
							status_name VARCHAR(255) NOT NULL DEFAULT 'NOT SET',
							status_shorthand VARCHAR(3) NOT NULL DEFAULT '-',
							PRIMARY KEY  (status_id)
						);";				
						
		$sql3 = "CREATE TABLE IF NOT EXISTS $table3name (
							user_id BIGINT(20) UNSIGNED,
							event_id INT NOT NULL,
							attendance INT NOT NULL,
							PRIMARY KEY  (user_id, event_id),
							FOREIGN KEY(event_id) REFERENCES $table1name (event_id),
							FOREIGN KEY(user_id) REFERENCES $usersTable (ID),
							FOREIGN KEY(attendance) REFERENCES $table2name (status_id)
						);";
				
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql1);
		dbDelta($sql2);
		dbDelta($sql3);
		
		$results = $wpdb->get_results("SELECT * FROM $table2name");
		
		if($results) {
		} else {
			$wpdb->query("INSERT INTO $table2name (status_name, status_shorthand) VALUES ('----', '-')");
			$wpdb->query("INSERT INTO $table2name (status_name, status_shorthand) VALUES ('Undecided', '?')");
			$wpdb->query("INSERT INTO $table2name (status_name, status_shorthand) VALUES ('Attending', 'Y')");
			$wpdb->query("INSERT INTO $table2name (status_name, status_shorthand) VALUES ('Not Attending', 'N')");
		}
		
		update_option("ultievt_version", $version);
	}
}
?>