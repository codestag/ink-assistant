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

/**
 *
 * @since 1.0
 */
function ink_assistant_activation_notice() {
	echo '<div class="error"><p>';
	echo esc_html__( 'Ink Assistant requires Ink WordPress Theme to be installed and activated.', 'ink-assistant' );
	echo '</p></div>';
}

/**
 *
 *
 * @since 1.0
 */
function ink_assistant_activation_check() {
	$theme = wp_get_theme(); // gets the current theme
	if ( 'Ink' == $theme->name || 'Ink' == $theme->parent_theme  ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			add_action( 'after_setup_theme', 'ink_assistant' );
		} else {
			ink_assistant();
		}
	} else {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'ink_assistant_activation_notice' );
	}
}

// Theme loads.
ink_assistant_activation_check();
