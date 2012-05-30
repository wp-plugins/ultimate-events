=== Ultimate Events ===
Plugin Name: Ultimate Events
Version: 1.3.3
Contributors: tehsmash
Author: Sam "Tehsmash" Betts
Author URI: http://www.code-smash.net
Tags: events, simple, quick, multiple, people, ultimate, shortcode
Requires at least: 3.3.2
Tested up to: 3.3.2
Stable tag: trunk
License: GPL2

A Plugin to manage multiple people attending multiple events.

== Description ==

A quick simple solution to the problem of hosting many events 
with many people attending, and needing to know who is going, 
who is not going, and who hasnt even bothered to check ;-).

== Installation == 

Step 1. Install the plugin from the wordpress repository.
	
Step 2. Activate the plugin through the 'Plugins' menu in WordPress.

== Uninstallation ==

@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
WARNING: This will also remove all data about events stored by Ultimate Events.
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Step 1. Deactivate the plugin. 

Step 2. Delete the plugin.

== Usage == 

To add an event go to the Ultimate Events Menu page and click Add New!
Complete the form and click the Submit button to save the event. 

To display events on your website and allow other users to subscribe to 
events add the [ultievt_display] shortcode to your wordpress page.

To display everyone's availability for various events, use the 
[ultievt_availability] shortcode in your wordpress page.

Editing events and also copying the data from events can be done in the 
Ultimate Events menu page inside the wordpress admin section.

Managing other users attendance can be done by the events admin via the 
'Manage Attendance' page included with the plugins backend.

== License == 

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
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301 USA

== Changelog == 
> 1.3.3
	- Event attendance statuses moved into a separate table to allow for expansion on defaults.
	- Beginning to implement a new settings menu to allow administrators to add/remove statuses.

> 1.2.4
	- Removed location from event availability page to allow for increased table space.
	
> 1.2.3
	- Added date to availabilty page 

> 1.2.2
	- Bug fixed, sideways text broken in most browsers, so removed and scroll bars added.

> 1.2.1
	- Added Manage Attendance page on the admin menu.
	- Added functionaity for admins to manage all users attendance to certain events.

> 1.1.0
	- Changed position of update button relative to the display table to make it easier to see.
	- Added cancelation notice to events, accessable via the edit event button. 

> 1.0 
	- Added Copy function and ability to handle links for the location.