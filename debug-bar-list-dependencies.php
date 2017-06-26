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


if ( ! function_exists( 'ps_listdeps_has_parent_plugin' ) ) {
	/**
	 * Show notice & de-activate itself if debug-bar plugin not active.
	 */
	function ps_listdeps_has_parent_plugin() {
		$file = plugin_basename( __FILE__ );

		if ( is_admin() && ( ! class_exists( 'Debug_Bar' ) && current_user_can( 'activate_plugins' ) ) && is_plugin_active( $file ) ) {
			add_action( 'admin_notices', create_function( null, 'echo \'<div class="error"><p>\', sprintf( __( \'Activation failed: Debug Bar must be activated to use the <strong>Debug Bar List Dependencies</strong> Plugin. <a href="%s">Visit your plugins page to install & activate</a>.\', \'debug-bar-list-dependencies\' ), admin_url( \'plugin-install.php?tab=search&s=debug+bar\' ) ), \'</p></div>\';' ) );

			deactivate_plugins( $file, false, is_network_admin() );

			// Add to recently active plugins list.
			if ( ! is_network_admin() ) {
				$insert = array(
					$file => time(),
				);

				update_option( 'recently_activated', ( $insert + (array) get_option( 'recently_activated' ) ) );
			} else {
				update_site_option( 'recently_activated', ( $insert + (array) get_site_option( 'recently_activated' ) ) );
			}

			// Prevent trying again on page reload.
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
	}
	add_action( 'admin_init', 'ps_listdeps_has_parent_plugin' );
}

