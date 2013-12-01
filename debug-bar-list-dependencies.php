<?php
/*
Plugin Name:  Debug Bar List Script & Style Dependencies
Version: 1.0.4
Plugin URI: http://soderlind.no/list-script-an…e-dependencies/ ‎
Description:
Author: Per Soderlind
Author URI: http://www.soderlind.no
*/


function ps_listdeps_debug_bar_panels( $a ) {
	if ( class_exists( 'Debug_Bar_Panel' ) ) {

		class ps_listdeps_Debug_Bar_Panel extends Debug_Bar_Panel {


			function init() {
				$this->enqueue();
			}

			function enqueue() {
				wp_enqueue_style( 'debug-bar-list-deps', plugins_url( "css/debug-bar-list-deps.css", __FILE__ ), array('debug-bar'), '1.0.2' );
			}

			function render( ) {
				global $wp_scripts, $wp_styles;

?>
			<div class="debug-bar-list-dependencies">
				<h2>Enqueued Scripts</h2>
				<table class="debug-bar-table deps-table">
					<thead>
						<tr><th>Order</th><th>Loaded</th><th>Dependencies</th></tr>
					</thead>
					<tbody>
					<?php
				$i = 1;
				$loaded_scripts = array_merge($wp_scripts->done, $wp_scripts->in_footer);
				$loaded_scripts = array_unique($loaded_scripts);

				foreach ( $loaded_scripts as $loaded_script) {

					echo '<tr><td>', $i, '<td>',
						$loaded_script,
						'</td><td>',
						( count( $wp_scripts->registered[$loaded_script]->deps ) > 0 ) ?  join(' and ', array_filter(array_merge(array(join(', ', array_slice($wp_scripts->registered[$loaded_script]->deps, 0, -1))), array_slice($wp_scripts->registered[$loaded_script]->deps, -1)))) : '&nbsp;',
						'</td></tr>',
						'<tr class="src"><td>&nbsp;</td><td colspan="2">',
						$wp_scripts->registered[$loaded_script]->src,
						'</td></tr>', "\n";
					$i++;
				}
?>
					</tbody>
  				</table>
  				<h2>Enqueued Styles</h2>
				<table class="debug-bar-table deps-table">
					<thead>
						<tr><th>Order</th><th>Loaded</th><th>Dependencies</th></tr>
					</thead>
					<tbody>
					<?php

				$i = 1;
				foreach ( $wp_styles->done as $loaded_styles ) {
					echo '<tr><td>', $i, '<td>',
						$loaded_styles,
						'</td><td>',
						( count( $wp_styles->registered[$loaded_styles]->deps ) > 0 ) ?  join(' and ', array_filter(array_merge(array(join(', ', array_slice($wp_styles->registered[$loaded_styles]->deps, 0, -1))), array_slice($wp_styles->registered[$loaded_styles]->deps, -1)))) : '&nbsp;',
						'</td></tr>',
						'<tr class="src"><td>&nbsp;</td><td colspan="2">',
						$wp_styles->registered[$loaded_styles]->src,
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


		$a[]=new ps_listdeps_Debug_Bar_Panel( 'Script & Style Dependencies' );
	}
	return $a;
}
add_filter( 'debug_bar_panels', 'ps_listdeps_debug_bar_panels' );
?>