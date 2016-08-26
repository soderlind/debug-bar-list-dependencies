<?php
/**
 * Debug Bar List Script & Style Dependencies - Debug Bar Panel.
 *
 * @package     WordPress\Plugins\Debug Bar List Dependencies
 * @author      Per Soderlind
 * @link        https://github.com/soderlind/debug-bar-list-dependencies
 * @version     1.1.1
 */

if ( class_exists( 'Debug_Bar_Panel' ) && ! class_exists( 'PS_Listdeps_Debug_Bar_Panel' ) ) {

	/**
	 * Debug Bar List Dependencies Panel.
	 */
	class PS_Listdeps_Debug_Bar_Panel extends Debug_Bar_Panel {

		const DBLD_NAME = 'debug-bar-list-deps';

		const DBLD_STYLES_VERSION = '1.1.1';

		/**
		 * Constructor.
		 */
		public function init() {
			$this->title( __( 'Script & Style Dependencies', 'debug-bar-list-dependencies' ) );

			$this->load_textdomain( 'debug-bar-list-dependencies' );

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		}

		/**
		 * Load the plugin text strings.
		 *
		 * Compatible with use of the plugin in the must-use plugins directory.
		 *
		 * @param string $domain Text domain to load.
		 */
		protected function load_textdomain( $domain ) {
			if ( is_textdomain_loaded( $domain ) ) {
				return;
			}

			$lang_path = dirname( plugin_basename( __FILE__ ) ) . '/languages';
			if ( false === strpos( __FILE__, basename( WPMU_PLUGIN_DIR ) ) ) {
				load_plugin_textdomain( $domain, false, $lang_path );
			} else {
				load_muplugin_textdomain( $domain, $lang_path );
			}
		}

		/**
		 * Enqueue the css file.
		 */
		public function enqueue() {
			$suffix = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min' );
			wp_enqueue_style( self::DBLD_NAME, plugins_url( 'css/debug-bar-list-deps' . $suffix . '.css', __FILE__ ), array( 'debug-bar' ), self::DBLD_STYLES_VERSION );
		}

		/**
		 * Render the output.
		 */
		public function render() {
			global $wp_scripts, $wp_styles;

			$loaded_scripts = array_merge( $wp_scripts->done, $wp_scripts->in_footer );
			$loaded_scripts = array_unique( $loaded_scripts );
			$styles         = $wp_styles->done;

			echo '
		<div class="debug-bar-list-dependencies">
			<h2><span>',
			esc_html__( 'Total Enqueued Scripts:', 'debug-bar-list-dependencies' ),
			'</span>', count( $loaded_scripts ), '</h2>
			<h2><span>',
			esc_html__( 'Total Enqueued Styles:', 'debug-bar-list-dependencies' ),
			'</span>', count( $styles ), '</h2>';

			$i = 1;
			$this->render_table_header( __( 'Enqueued Scripts', 'debug-bar-list-dependencies' ) );
			foreach ( $loaded_scripts as $loaded_script ) {
				$this->render_table_row(
					$i,
					$loaded_script,
					$wp_scripts->registered[ $loaded_script ]->deps,
					$wp_scripts->registered[ $loaded_script ]->src
				);
				$i++;
			}
			$this->render_table_close();

			$i = 1;
			$this->render_table_header( __( 'Enqueued Styles', 'debug-bar-list-dependencies' ) );
			foreach ( $styles as $loaded_styles ) {
				$this->render_table_row(
					$i,
					$loaded_styles,
					$wp_styles->registered[ $loaded_styles ]->deps,
					$wp_styles->registered[ $loaded_styles ]->src
				);
				$i++;
			}
			$this->render_table_close();

			echo '
		</div>';
		}

		/**
		 * Render the table header.
		 *
		 * @param string $title Panel title.
		 */
		private function render_table_header( $title ) {
			echo '
  				<h3>', esc_html( $title ), '</h3>
			<table class="debug-bar-table deps-table">
				<thead>
					<tr><th>',
					esc_html__( 'Order', 'debug-bar-list-dependencies' ),
					'</th><th>',
					esc_html__( 'Loaded', 'debug-bar-list-dependencies' ),
					'</th><th>',
					esc_html__( 'Dependencies', 'debug-bar-list-dependencies' ),
					'</th></tr>
				</thead>
				<tbody>';
		}

		/**
		 * Render a table row.
		 *
		 * @param int    $row_nr       The row number.
		 * @param string $item         The current item to render.
		 * @param array  $dependencies The dependencies for the current item.
		 * @param string $src          The source url for the current item.
		 */
		private function render_table_row( $row_nr, $item, $dependencies, $src ) {
			echo '<tr><td>', (int) $row_nr, '</td><td>',
				esc_html( $item ),
				'</td><td>';

			if ( ! empty( $dependencies ) && is_array( $dependencies ) ) {
				$dependency_string = '';

				// Remove the last item from $dependencies & remember it.
				$last = array_pop( $dependencies );

				if ( ! empty( $dependencies ) ) {
					$dependency_string = esc_html( implode( ', ', $dependencies ) ) .
						' <span class="glue">' . esc_html__( 'and', 'debug-bar-list-dependencies' ) . '</span> ';
				}

				echo $dependency_string, esc_html( $last ); // WPCS: XSS ok.
			} else {
				echo '&nbsp;';
			}

			echo '</td></tr>',
				'<tr class="src"><td>&nbsp;</td><td colspan="2">',
				esc_html( $src ),
				'</td></tr>', "\n";
		}

		/**
		 * Render the table closing.
		 */
		private function render_table_close() {
			echo '
				</tbody>
  				</table>';
		}
	}
}
