<?php
/**
 * Display featured slide item for featured sliders.
 *
 * @package Ink
 */
class Stag_Widget_Featured_Slides extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_widget_feature_slides';
		$this->widget_cssclass    = 'stag_widget_feature_slides full-wrap';
		$this->widget_description = esc_html__( 'Displays all contents under &ldquo;Featured Slides Sidebar&rdquo; Area.', 'ink-assistant' );
		$this->widget_name        = esc_html__( 'Section: Featured Slides', 'ink-assistant' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title:', 'ink-assistant' ),
			),
			'text_color' => array(
				'type'  => 'colorpicker',
				'std'   => '#000',
				'label' => esc_html__( 'Text Color:', 'ink-assistant' ),
			),
			'link_color' => array(
				'type'  => 'colorpicker',
				'std'   => '#000',
				'label' => esc_html__( 'Link Color:', 'ink-assistant' ),
			),
			'content_position' => array(
				'type'  => 'select',
				'std'   => 'slide-content-left',
				'label' => esc_html__( 'Content Position:', 'ink-assistant' ),
				'options' => array(
					'slide-content-left'   => esc_html__( 'Left', 'ink-assistant' ),
					'slide-content-center' => esc_html__( 'Center', 'ink-assistant' ),
					'slide-content-right'  => esc_html__( 'Right', 'ink-assistant' ),
				),
			),
			'flex_transition' => array(
				'type'  => 'select',
				'std'   => 'fade',
				'label' => esc_html__( 'Transition Effect:', 'ink-assistant' ),
				'options' => array(
					'fade'  => esc_html__( 'Fade', 'ink-assistant' ),
					'slide' => esc_html__( 'Slide', 'ink-assistant' ),
				),
			),
			'flex_speed' => array(
				'type'  => 'number',
				'std'   => 4,
				'step'  => 1,
				'min'   => 1,
				'max'   => 100,
				'label' => esc_html__( 'Speed of the slideshow change in seconds:', 'ink-assistant' ),
			),
			'flex_pause' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Pause slideshow when hover?', 'ink-assistant' ),
			),
			'slide_pagination' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Show slide pagination?', 'ink-assistant' ),
			),
			'hide_on_mobile' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Hide on mobile?', 'ink-assistant' ),
			),
		);

		parent::__construct();

	}

	/**
	 * Widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();

		extract( $args );

		$title            = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$text_color       = stag_maybe_hash_hex_color( $instance['text_color'] );
		$link_color       = stag_maybe_hash_hex_color( $instance['link_color'] );
		$content_position = isset( $instance['content_position'] ) ? esc_attr( $instance['content_position'] ) : 'slide-content-left';
		$flex_transition  = isset( $instance['flex_transition'] ) ? esc_attr( $instance['flex_transition'] ) : 'fade';
		$flex_speed       = absint( $instance['flex_speed'] );
		$flex_pause       = absint( $instance['flex_pause'] );
		$pagination       = isset( $instance['slide_pagination'] ) ? absint( $instance['slide_pagination'] ) : false;
		$hide_on_mobile   = isset( $instance['hide_on_mobile'] ) ? absint( $instance['hide_on_mobile'] ) : false;

		echo  $before_widget;

		wp_enqueue_script( 'flexslider', get_theme_file_uri( '/assets/js/jquery.flexslider.js' ), array( 'jquery' ), '2.6.3', true );

		?>

		<style type="text/css">
			.site-slider .slide-desc {
				color: <?php echo esc_html( $text_color ); ?>;
			}
			.site-slider .slide-desc a:not(.button) { color: <?php echo esc_html( $link_color ); ?>; }
		</style>

		<section class="featured-slides <?php echo esc_attr( $content_position ); ?>" data-transition="<?php echo esc_attr( $flex_transition ); ?>" data-speed="<?php echo esc_attr( $flex_speed ); ?>" data-pause="<?php echo esc_attr( $flex_pause ); ?>" data-pagination="<?php echo esc_attr( $pagination ) ?>" data-hideonmobile="<?php echo esc_attr( $hide_on_mobile ) ?>">
			<div class="site-slider loading">
				<ul class="slides"><?php dynamic_sidebar( 'sidebar-4' ); ?></ul>
				<div class="control-nav-container <?php echo esc_attr( $content_position ); ?>"></div>
			</div>
		</section>

		<?php
		echo  $after_widget;

		wp_reset_postdata();

		$content = ob_get_clean();

		echo  $content;

		$this->cache_widget( $args, $content );
	}

	/**
	 * Registers the widget with the WordPress Widget API.
	 *
	 * @return mixed
	 */
	public static function register() {
		register_widget( __CLASS__ );
	}
}

add_action( 'widgets_init', array( 'Stag_Widget_Featured_Slides', 'register' ) );
