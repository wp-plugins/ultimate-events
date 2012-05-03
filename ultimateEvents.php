<?php
global $version;
$version = "1.1.0";
/*
Plugin Name: Ultimate Events
Description: A Plugin to manage people attending multiple events
Version: 1.1.0
Author: Sam "Tehsmash" Betts
Author URI: http://www.code-smash.net
License: GPL2

Copyright 2012  Sam "Tehsmash" Betts  (email : sam@code-smash.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/************ Include other plugin files  *************/
include 'ultimateEvents_setup.php';
include 'ultimateEvents_functions.php';

/****************** Activation Stuff ******************/
register_activation_hook(__FILE__,'ultievt_install'); 

/****************** Check for update ******************/
add_action('plugins_loaded', 'ultievt_install');

/****************** User Stuff ******************/
function ultievt_display() {
	return ultievt_shortcode('ultimateEvents_display.php');
}

function ultievt_availability() {
	return ultievt_shortcode('ultimateEvents_availability.php');
}

add_shortcode('ultievt_display', 'ultievt_display');
add_shortcode('ultievt_availability', 'ultievt_availability');

/****************** Admin Backend Stuff ******************/
function ultievt_admin_actions() {
	$iconURL = plugin_dir_url( __FILE__ ) . 'images/icon16.png';
	add_menu_page('Ultimate Events', 'Ultimate Events', 'edit_pages', 'ultimate_events_menu', 'ultievt_editor', $iconURL);
}

function ultievt_editor() {
	include ('ultimateEvents_editor.php');
}

add_action('admin_menu', 'ultievt_admin_actions');
?>
