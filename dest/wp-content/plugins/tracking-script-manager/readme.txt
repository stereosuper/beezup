=== Tracking Script Manager ===
Contributors: eltodd, JHipkin, red8developers, bkueker, yingling017
Donate link: http://red8interactive.com/
Tags: adwords, analytics, conversion pixel, conversion tracking, facebook pixel, google adwords, google analytics, google tag manager, Marketo tracking scripts, Hubspot tracking scripts, Pardot tracking script, Eloqua tracking script, javascript, pixel tracking, remarketing, retargeting, tracking code, tracking script
Requires at least: 3.0.1
Tested up to: 5.3
Stable tag: 2.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy tag management. Manage the tracking tags, codes and scripts you use in your WordPress site; easily add, update, reorder, delete, as required.

== Description ==

Easily add tags, scripts, and code, or manage existing tags, scripts, and code including placement, editing, updating, reordering and deactivating.

Tracking Script Manager lets you can place and manage tracking tags and scripts in the header, footer or after the body tag. The script can appear globally or on specific pages or posts. (The after body tag placement may require an update to your theme files. See the <a href="https://red8interactive.com/products/tracking-scripts-manager/">plugin’s</a> page for more information.)

Tracking Script Manager is especially useful for managing advertising tags, social media tracking and retargeting scripts, Facebook and AdWords for example, analytic scripts including Google Analytics, and promotional scripts. It can also be used to manage conversion tracking tags and scripts for marketing automation or e-commerce or any other desired action.

== Installation ==

1. Upload the 'tracking-script-manager' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Click on the 'Tracking Scripts Manager' options page.

== Frequently Asked Questions ==

= How do I add a script? =

You can add a script by navigating to the Tracking Scripts Manager menu in the sidebar, and selecting Add New Tracking Script.

= How do I delete a script? =

On the Tracking Script Manager menu in the sidebar, you can delete a script like you would a normal post.

= How do I reorder scripts? =

Inside the script post, in the right hand sidebar underneath the publish options; there is an order field. Lower numbers mean higher priority.

= Using the body location =

To use the body script location, you will need to add a line of PHP to directly after the opening `<body>` tag in your theme's files. Typically this can be found in header.php but can vary theme to theme. 

`<?php do_action('wp_body_open'); ?>`

After that line is added to your theme, when creating or editing a script; you can select the "After `<body>`" script location for that script to appear.

== Screenshots ==

1. Control Description
2. Using the "After <body>" script location.
3. View your Tracking Scripts.
4. Add a new Tracking Script to a specific post or page (including custom post types).

== Changelog ==

= 2.0.5 =
* Adding fallback for wp_body_open *

= 2.0.4 =
* Changing capability for which admin notices appear

= 2.0.3 =
* Adding in a couple descriptions for controls, and a new screenshot

= 2.0.2 =
* Fixing a typo

= 2.0.1 =
* Fixed issue when updating scripts to new version

= 2.0.0 =
* Converted scripts into a post type for easier management
* Added background processing for upgrading current scripts to the updated version
* Added a hook that can be included after the body in the theme to allow scripts to be pulled in to that location

= 1.1.6 =
* Adding in ability for text translations

= 1.1.5 =
* Updating wording throughout the plugin for better continuity

= 1.1.4 =
* Another admin menu tweak

= 1.1.3 =
* Admin menu tweak

= 1.1.2 =
* Removed some unnecessary hooks

= 1.1.1 =
* Fixed a few PHP warnings from last update

= 1.1 =
* Major Upgrade: Allows for scripts to be added to a specific page

= 1.0.9 =
* Cleaning up script enqueuing

= 1.0.8 =
* Fixed issues causing some conflicts with WP styling

= 1.0.7 =
* Fixed CSS issues

= 1.0.6 =
* Fixed some php warnings

= 1.0.5 =
* Fixed decoding issue

= 1.0.4 =
* Fixed plugin URI

= 1.0.3 =
* Fixes redirect issue

= 1.0.2 =
* Fixes issue with tabs

= 1.0.1 =
* Fixes a Javascript issue

= 1.0.0 =
* Initial plugin release

== Upgrade Notice ==

= 1.1.6 =
Adding in ability for text translations

= 1.1.5 =
Updating wording throughout the plugin for better continuity

= 1.1.4 =
Another admin menu tweak

= 1.1.3 =
Admin menu tweak

= 1.1.2 =
Removed some unnecessary hooks

= 1.1.1 =
Fixed a few PHP warnings from last update

= 1.1 =
Major Upgrade: Allows for scripts to be added to a specific page

= 1.0.9 =
Cleaning up script enqueuing

= 1.0.8 =
Fixed issues causing some conflicts with WP styling

= 1.0.7 =
Fixed CSS issues

= 1.0.6 =
Fixed some php warnings

= 1.0.5 =
Fixed decoding issue

= 1.0.4 =
Fixed plugin URI

= 1.0.3 =
Fixes redirect issue

= 1.0.2 =
Fixes issue with tabs

= 1.0.1 =
This upgrade fixes a Javascript issue with version 1.0.0
