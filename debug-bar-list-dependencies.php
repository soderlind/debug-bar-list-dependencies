<?php
/*
Plugin Name:  Debug Bar List Script & Style Dependencies
Version: 1.0
Plugin URI: http://soderlind.no/list-script-an…e-dependencies/ ‎
Description:
Author: Per Soderlind
Author URI: http://www.soderlind.no
*/


function ps_listdeps_debug_bar_panels( $a ) {
	if ( class_exists( 'Debug_Bar_Panel' ) ) {

		class ps_listdeps_Debug_Bar_Panel extends Debug_Bar_Panel {

			function render( ) {
				global $wp_scripts, $wp_styles;
?>
			<div class="xx">

				<table width="100%" cellspacing="2" cellpadding="5" class="form-table">
					<tr><th colspan="3" style="font-size: 1.5em;font-weight: bold">Enqueued Scripts</th></tr>
					<tr><td>Order</td><td><b>Loaded</b></td><td><b>Dependencies</b></td></tr>
					<?php
				$i = 1;
				
				foreach ( $wp_scripts->do_items() as $loaded_scripts ) {

					echo '<tr style="background-color:',  ( $i % 2 === 0 ) ? '#eee' : '#fff' , '"><td>', $i, '<td>', $loaded_scripts, '</td><td>', ( count( $wp_scripts->registered[$loaded_scripts]->deps ) > 0 ) ?  implode( " and ", $wp_scripts->registered[$loaded_scripts]->deps ) : '', '</td></tr>', "\n";
					$i++;
				}
?>
					<tr><th colspan="3" style="font-size: 1.5em;font-weight: bold">Enqueued Styles</th></tr>
					<tr><td>Order</td><td><b>Loaded</b></td><td><b>Dependencies</b></td></tr>
					<?php

				 $i = 1;
				foreach ( $wp_styles->do_items() as $loaded_styles ) {
					echo '<tr style="background-color:',  ( $i % 2 === 0 ) ? '#eee' : '#fff' , '"><td>', $i, '<td>', $loaded_styles, '</td><td>', ( count( $wp_styles->registered[$loaded_styles]->deps ) > 0 ) ?  implode( " and ", $wp_styles->registered[$loaded_styles]->deps ) : '', '</td></tr>', "\n";
					$i++;
				}
?>
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
