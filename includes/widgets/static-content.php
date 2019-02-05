<?php
/**
 * Display static content from an specific page.
 *
 * @since Ink 1.0
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */
class Stag_Widget_Static_Content extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_widget_static_content';
		$this->widget_cssclass    = 'stag_widget_static_content full-wrap';
		$this->widget_description = __( 'Displays content from a specific page.', 'stag' );
		$this->widget_name        = __( 'Section: Static Content', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Title:', 'stag' ),
			),
			'page' => array(
				'type'  => 'page',
				'std'   => '',
				'label' => __( 'Select Page:', 'stag' ),
			),
			'bg_color' => array(
				'type'  => 'colorpicker',
				'std'   => stag_theme_mod( 'colors', 'accent' ),
				'label' => __( 'Background Color:', 'stag' ),
			),
			'bg_opacity' => array(
				'type'  => 'number',
				'std'   => '20',
				'step'  => '5',
				'min'   => '0',
				'max'   => '100',
				'label' => __( 'Background Image Opacity:', 'stag' ),
			),
			'bg_image' => array(
				'type'  => 'image',
				'std'   => null,
				'label' => __( 'Background Image:', 'stag' ),
			),
			'text_color' => array(
				'type'  => 'colorpicker',
				'std'   => '#ffffff',
				'label' => __( 'Text Color:', 'stag' ),
			),
			'link_color' => array(
				'type'  => 'colorpicker',
				'std'   => '#f8f8f8',
				'label' => __( 'Link Color:', 'stag' ),
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

		$title      = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$page       = $instance['page'];
		$bg_color   = $instance['bg_color'];
		$bg_opacity = $instance['bg_opacity'];
		$bg_image   = $instance['bg_image'];
		$text_color = $instance['text_color'];
		$link_color = $instance['link_color'];
		$post       = new WP_Query( array( 'page_id' => $page ) );

		echo $before_widget;

		// Allow site-wide customization of the 'Read more' link text.
		$read_more = apply_filters( 'stag_read_more_text', __( 'Read more', 'stag' ) );
		?>
		<style type="text/css">
			#<?php echo $widget_id; ?> {
				background-color: <?php echo $bg_color; ?>;
				color: <?php echo $text_color; ?>;
			}
			#<?php echo $widget_id; ?> .static-content-cover {
				background-image: url(<?php echo esc_url( $bg_image ); ?>);
				opacity: <?php echo $bg_opacity/100; ?>;
			}
			#<?php echo $widget_id; ?> a:not(.button) {
				color: <?php echo $link_color; ?>;
				border-color: <?php echo $link_color; ?>;;
			}

			#<?php echo $widget_id; ?> h1,
			#<?php echo $widget_id; ?> h2,
			#<?php echo $widget_id; ?> h3,
			#<?php echo $widget_id; ?> h4,
			#<?php echo $widget_id; ?> h5,
			#<?php echo $widget_id; ?> h6 {
				color: <?php echo $text_color; ?>;
			}

		</style>
		<div class="static-content-cover"></div>
		<section class="inner-section">

			<?php if ( $post->have_posts() ) : ?>
				<?php while ( $post->have_posts() ) : $post->the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if ( $title ) echo $before_title . $title . $after_title; ?>

						<div class="entry-content">
							<?php the_content( $read_more ); ?>
						</div>
					</article>
				<?php endwhile; ?>
			<?php endif; ?>

		</section>

		<?php
		echo $after_widget;

		wp_reset_postdata();

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}

	/**
	 * Registers the widget with the WordPress Widget API.
	 */
	public static function register() {
		register_widget( __CLASS__ );
	}
}

add_action( 'widgets_init', array( 'Stag_Widget_Static_Content', 'register' ) );
