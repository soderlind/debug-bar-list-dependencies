<?php
/**
 * Debug Bar List Script & Style Dependencies, a WordPress plugin.
 *
 * @package     WordPress\Plugins\Debug Bar List Dependencies
 * @author      Per Soderlind
 * @link        https://github.com/soderlind/debug-bar-list-dependencies
 * @version     1.1.1
 *
 * @wordpress-plugin
 * Plugin Name: Debug Bar List Script & Style Dependencies
 * Plugin URI:  http://soderlind.no/debug-bar-list-script-and-style-dependencies/
 * Description: Debug Bar List Script & Style Dependencies is an add-on to WordPress Debug Bar.
 * Version:     1.1
 * Author:      Per Soderlind
 * Author URI:  http://www.soderlind.no/
 * Author:      Juliette Reinders Folmer
 * Author URI:  http://adviesenzo.nl/
 * Depends:     Debug Bar
 * Text Domain: debug-bar-list-dependencies
 * Domain Path: /languages
 */

if ( ! function_exists( 'ps_listdeps_debug_bar_panels' ) ) {
	/**
	 * Add a Scripts & Styles dependencies panel to the Debug Bar.
	 *
	 * @param array $panels Existing debug bar panels.
	 *
	 * @return array
	 */
	function ps_listdeps_debug_bar_panels( $panels ) {
		if ( ! class_exists( 'PS_Listdeps_Debug_Bar_Panel' ) ) {
			require_once 'class-debug-bar-list-dependencies.php';
		}
		$panels[] = new PS_Listdeps_Debug_Bar_Panel();
		return $panels;
	}

	add_filter( 'debug_bar_panels', 'ps_listdeps_debug_bar_panels' );
}
