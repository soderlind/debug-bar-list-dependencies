<?php
/*
Plugin Name:  Debug Bar List Script & Style Dependencies
Version: 1.0.2
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
			<div class="xx">

				<table width="100%" cellspacing="2" cellpadding="5" class="deps-table">
					<tr><th colspan="3" style="font-size: 1.5rem;font-weight: bold">Enqueued Scripts</th></tr>
					<tr><td>Order</td><td><b>Loaded</b></td><td><b>Dependencies</b></td></tr>
					<?php
				$i = 1;
				
				foreach ( $wp_scripts->do_items() as $loaded_scripts ) {

					echo '<tr style="background-color:',  ( $i % 2 === 0 ) ? '#eee' : '#fff' , '"><td>', $i, '<td>', $loaded_scripts,'<br/>',$wp_scripts->registered[$loaded_scripts]->src, '</td><td>', ( count( $wp_scripts->registered[$loaded_scripts]->deps ) > 0 ) ?  join(' and ', array_filter(array_merge(array(join(', ', array_slice($wp_scripts->registered[$loaded_scripts]->deps, 0, -1))), array_slice($wp_scripts->registered[$loaded_scripts]->deps, -1)))) : '', '</td></tr>', "\n";
					$i++;
				}
?>
					<tr><th colspan="3" style="font-size: 1.5rem;font-weight: bold">Enqueued Styles</th></tr>
					<tr><td>Order</td><td><b>Loaded</b></td><td><b>Dependencies</b></td></tr>
					<?php

				 $i = 1;
				foreach ( $wp_styles->do_items() as $loaded_styles ) {
					echo '<tr style="background-color:',  ( $i % 2 === 0 ) ? '#eee' : '#fff' , '"><td>', $i, '<td>', $loaded_styles, '</td><td>', ( count( $wp_styles->registered[$loaded_styles]->deps ) > 0 ) ?  join(' and ', array_filter(array_merge(array(join(', ', array_slice($wp_styles->registered[$loaded_styles]->deps, 0, -1))), array_slice($wp_styles->registered[$loaded_styles]->deps, -1)))) : '', '</td></tr>', "\n";
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

/*

http://cdnjs.cloudflare.com/ajax/libs/$name/$version/$filename

http://cdnjs.com/packages.json:

"packages": [
        {
            "name": "1140",
            "filename": "1140.css",
            "version": "2.0",
            "description": "The 1140 grid fits perfectly into a 1280 monitor. On smaller monitors it becomes fluid and adapts to the width of the browser.",
            "homepage": "http://cssgrid.net/",
            "keywords": [
                "1140"
            ],
            "maintainers": [
                {
                    "name": "Andy Taylor",
                    "web": "http://www.andytlr.com/"
                }
            ],
            "repositories": [],
            "assets": [
                {
                    "version": "2.0",
                    "files": [
                        "1140.css",
                        "1140.min.css"
                    ]
                }
            ]
        }

*/

