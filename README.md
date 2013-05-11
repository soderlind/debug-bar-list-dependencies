
## WordPress Debug Bar, List Script &amp; Style Dependencies

WordPress Debug Bar, List Script &amp; Style Dependencies is an add-on to WordPress [Debug Bar](http://wordpress.org/extend/plugins/debug-bar/)

-----------------------

### Overview

We all know that when we're add a script or style to WordPress, we should use `wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer )` and `wp_enqueue_style( $handle, $src, $deps, $ver, $media )`

`$deps` (dependencies), the handle name and an optional parameter, lets you control when/where your script or style should be added. If `$deps` is `array('jquery')`, your script will be loaded after jquery is loaded.

The problem is, which one exists and in which order are they loaded ?

WordPress Debug Bar, List Script &amp; Style Dependencies, an add-on to [Debug Bar](http://wordpress.org/extend/plugins/debug-bar/), will list the dependencies.

### Installation

1. Copy the 'debug-bar-list-dependencies' folder into your plugins folder
1. Activate the plugin via the Plugins admin page

### Use

Script and styles loaded on the front-end: Go to the front-end, and on the admin bar choose Debug and view Script & Style Dependencies

Back-end: Do the same, on the admin bar choose Debug and view Script & Style Dependencies

Note, the front-end and back-end loads different scripts and styles.


### More Information

* http://soderlind.no/debug-bar-list-script-and-style-dependencies/
* http://codex.wordpress.org/Function_Reference/wp_enqueue_script
* http://codex.wordpress.org/Function_Reference/wp_enqueue_style