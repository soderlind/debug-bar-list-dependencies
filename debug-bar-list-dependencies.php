<?php
/*
Plugin Name:  Debug Bar List Script & Style Dependencies
Version:      1.0.5
Plugin URI:   http://soderlind.no/debug-bar-list-script-and-style-dependencies/
Description:  Debug Bar List Script & Style Dependencies is an add-on to WordPress Debug Bar
Author:       Per Soderlind
Author URI:   http://www.soderlind.no
Depends:      Debug Bar
Text Domain:  debug-bar-list-dependencies
Domain Path:  /languages/
*/


function ps_listdeps_debug_bar_panels( $a ) {
	if ( class_exists( 'Debug_Bar_Panel' ) ) {

		class ps_listdeps_Debug_Bar_Panel extends Debug_Bar_Panel {
			
			const DBLD_NAME = 'debug-bar-list-deps';

			const DBLD_STYLES_VERSION = '1.0.5';

			function init() {
				$this->enqueue();
				load_plugin_textdomain( self::DBLD_NAME, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			}

			function enqueue() {
				$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
				wp_enqueue_style( self::DBLD_NAME, plugins_url( 'css/debug-bar-list-deps' . $suffix . '.css', __FILE__ ), array( 'debug-bar' ), self::DBLD_STYLES_VERSION );
			}

			function render( ) {
				global $wp_scripts, $wp_styles;
				
				$loaded_scripts = array_merge($wp_scripts->done, $wp_scripts->in_footer);
				$loaded_scripts = array_unique($loaded_scripts);
				$styles = $wp_styles->done;


?>
			<div class="debug-bar-list-dependencies">
				<h2><span><?php echo esc_html__( 'Total Enqueued Scripts:', self::DBLD_NAME ); ?></span><?php echo count( $loaded_scripts ); ?></h2>
				<h2><span><?php echo esc_html__( 'Total Enqueued Styles:', self::DBLD_NAME ); ?></span><?php echo count( $styles ); ?></h2>

				<h3><?php echo esc_html__( 'Enqueued Scripts', self::DBLD_NAME ); ?></h3>
				<table class="debug-bar-table deps-table">
					<thead>
						<tr><th><?php echo esc_html__( 'Order', self::DBLD_NAME ); ?></th><th><?php echo esc_html__( 'Loaded', self::DBLD_NAME ); ?></th><th><?php echo esc_html__( 'Dependencies', self::DBLD_NAME ); ?></th></tr>
					</thead>
					<tbody>
					<?php
				$i = 1;

				foreach ( $loaded_scripts as $loaded_script) {

					echo '<tr><td>', $i, '<td>',
						$loaded_script,
						'</td><td>',
						( count( $wp_scripts->registered[$loaded_script]->deps ) > 0 ) ?  join( ' ' . __( 'and', self::DBLD_NAME ) . ' ', array_filter(array_merge(array(join(', ', array_slice($wp_scripts->registered[$loaded_script]->deps, 0, -1))), array_slice($wp_scripts->registered[$loaded_script]->deps, -1)))) : '&nbsp;',
						'</td></tr>',
						'<tr class="src"><td>&nbsp;</td><td colspan="2">',
						esc_html($wp_scripts->registered[$loaded_script]->src),
						'</td></tr>', "\n";
					$i++;
				}
?>
					</tbody>
  				</table>
  				<h3><?php echo esc_html__( 'Enqueued Styles', self::DBLD_NAME ); ?></h3>
				<table class="debug-bar-table deps-table">
					<thead>
						<tr><th><?php echo esc_html__( 'Order', self::DBLD_NAME ); ?></th><th><?php echo esc_html__( 'Loaded', self::DBLD_NAME ); ?></th><th><?php echo esc_html__( 'Dependencies', self::DBLD_NAME ); ?></th></tr>
					</thead>
					<tbody>
					<?php

				$i = 1;
				foreach ( $styles as $loaded_styles ) {
					echo '<tr><td>', $i, '<td>',
						$loaded_styles,
						'</td><td>',
						( count( $wp_styles->registered[$loaded_styles]->deps ) > 0 ) ?  join( ' ' . __( 'and', self::DBLD_NAME ) . ' ', array_filter(array_merge(array(join(', ', array_slice($wp_styles->registered[$loaded_styles]->deps, 0, -1))), array_slice($wp_styles->registered[$loaded_styles]->deps, -1)))) : '&nbsp;',
						'</td></tr>',
						'<tr class="src"><td>&nbsp;</td><td colspan="2">',
						esc_html($wp_styles->registered[$loaded_styles]->src),
						'</td></tr>', "\n";
					$i++;
				}
?>
					</tbody>
				</table>
			</div>
			<?php
			}
		}


		$a[]=new ps_listdeps_Debug_Bar_Panel( __( 'Script & Style Dependencies', ps_listdeps_Debug_Bar_Panel::DBLD_NAME ) );
	}
	return $a;
}
add_filter( 'debug_bar_panels', 'ps_listdeps_debug_bar_panels' );
?>