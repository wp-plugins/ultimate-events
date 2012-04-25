<?php
function table_exists($table_name) {
	global $wpdb;	
	foreach($wpdb->get_col("SHOW TABLES", 0) as $table) {
		if($table == $table_name) {
			return true;
		}
	}
	return false;
}

function ultievt_shortcode($filename) {
		ob_start();
		include $filename;
		$output=ob_get_contents();
		ob_end_clean();
		return $output;
}
?>