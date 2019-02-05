<?php
/**
 * Plugin Name: Ink Assistant
 * Plugin URI: https://github.com/lushkant/ink-assistant
 * Description: A plugin to assit INK theme in adding widgets.
 * Author: Codestag
 * Author URI: https://codestag.com
 * Version: 1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package INK
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ink_Assistant' ) ) :
	/**
	 *
	 * @since 1.0
	 */
	class Ink_Assistant {

		/**
		 *
		 * @since 1.0
		 */
		private static $instance;

		/**
		 *
		 * @since 1.0
		 */
		public static function register() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceOf Ink_Assistant ) ) {
				self::$instance = new Ink_Assistant();
				self::$instance->init();
				self::$instance->define_constants();
				self::$instance->includes();
			}
		}

		/**
		 *
		 * @since 1.0
		 */
		public function init() {
			add_action( 'enqueue_assets', 'plugin_assets' );
		}

		/**
		 *
		 * @since 1.0
		 */
		public function define_constants() {
			$this->define( 'IA_VERSION', '1.0' );
			$this->define( 'IA_DEBUG', true );
			$this->define( 'IA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'IA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 *
		 * @param string $name
		 * @param string $value
		 * @since 1.0
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 *
		 * @since 1.0
		 */
		public function includes() {
			require_once IA_PLUGIN_PATH . 'includes/widgets/contributors.php';
			require_once IA_PLUGIN_PATH . 'includes/widgets/feature-callout.php';
			require_once IA_PLUGIN_PATH . 'includes/widgets/featured-slide.php';
			require_once IA_PLUGIN_PATH . 'includes/widgets/recent-posts-grid.php';
			require_once IA_PLUGIN_PATH . 'includes/widgets/section-featured-slides.php';
			require_once IA_PLUGIN_PATH . 'includes/widgets/static-content.php';
		}
 	}
endif;


/**
 *
 * @since 1.0
 */
function ink_assistant() {
	return Ink_Assistant::register();
}

if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	add_action( 'plugins_loaded', 'ink_assistant', 90 );
} else {
	xblocks();
}
