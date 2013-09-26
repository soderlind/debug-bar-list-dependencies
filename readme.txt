=== Debug Bar List Script & Style Dependencies ===
Contributors: PerS
Donate link: http://soderlind.no/donate/
Tags: debug, debug bar, development, wp_enqueue_script, wp_enqueue_style, script, styles, dependencies
Requires at least: 3.4
Tested up to: 3.5.1
Stable tag: 1.0.3
License: GPLv2 or later

Debug Bar List Script & Style Dependencies is an add-on to WordPress Debug Bar

== Description ==

We all know that when we're add a script or style to WordPress, we should use `wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer )` and `wp_enqueue_style( $handle, $src, $deps, $ver, $media )` as in:

`
function themeslug_enqueue_style() {
	wp_enqueue_style( 'core', 'style.css', array('twentytwelve-style') ); 
}

function themeslug_enqueue_script() {
	wp_enqueue_script( 'my-js', 'filename.js', array('jquery') );
}

add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_script' )
`

$deps (dependencies), the handle name and an optional parameter, lets you control when/where your script or style should be added. If $deps is `array('jquery')`, your script will be loaded after jquery is loaded.

The problem is, which one exists and in which order are they loaded ?

Debug Bar List Script &amp; Style Dependencies, an add-on to [Debug Bar](http://wordpress.org/extend/plugins/debug-bar/), will list the dependencies.

= Use =

To view the loaded scripts and styles

* Front-end: Go to the front-end, and on the admin bar choose Debug and view Script & Style Dependencies
* Back-end: Go to the back-end, on the admin bar choose Debug and view Script & Style Dependencies

Note, the front-end and back-end loads different scripts and styles. Also, different pages on the front-end and back-end can load different scripts and styles.

== Installation ==

1. Copy the 'debug-bar-list-dependencies' folder into your plugins folder
1. Activate the plugin via the Plugins admin page


== Screenshots ==

1. Front-end dependencies
1. Back-end dependencies

== Changelog ==

= 1.0.3 =
* (Partial) Bugfix for [Help tabs broken and missing scripts](https://github.com/soderlind/debug-bar-list-dependencies/issues/1)
* Fix: duplicate script listings
* New!: un-obtrusive script/style source line
* Some other minor adjustments to compensate for the front-end themes

= 1.0.2 =
* Added styling
= 1.0.1 =
* Bugfix, fixed listing of styles and their dependencies
= 1.0 = 
* Initial release

