<?php
/**
 * Display Subscribe/Login button on restricted pages.
 *
 * @package Ink Assistant
 * @subpackage Ink
 * @return void
 */
function stag_rcp_locked_options( $atts ) {
	if ( ! stag_is_rcp_active() ) {
		return;
	}

	$args = shortcode_atts(
		array(
			'button' => '',
		),
		$atts,
		'locked_options'
	);

	global $user_ID, $rcp_options;

	$is_displayed      = $show_login_button = false;
	$registration_page = $rcp_options['registration_page'];

	if ( ! is_user_logged_in() ) {
		$show_login_button = true;
	}

	$has_access = ( ! rcp_is_paid_user( $user_ID ) && isset( $registration_page ) && $registration_page != '' ) ? true : false;

	if ( isset( $args['button'] ) && $args['button'] != '' ) {
		$button_color = $args['button'];
	} else {
		$background_color = stag_get_post_meta( 'settings', get_the_ID(), 'post-background-color' );
		$button_color     = ( $background_color === '' && ! has_post_thumbnail() ) ? 'black' : 'white';

		if ( is_single() ) {
			$button_color = 'black';
		}
	}

	ob_start();

	?>

	<div class="locked-options<?php echo ( $has_access ) ? ' no-access' : ' has-access'; ?> <?php echo esc_attr( $button_color ); ?>-buttons">
		<?php if ( $has_access ) : ?>
			<a href="<?php echo esc_url( get_permalink( $registration_page ) ); ?>" class="stag-button stag-button--normal stag-button--<?php echo esc_attr( $button_color ); ?>"><?php esc_html_e( 'Subscribe', 'ink-assistant' ); ?></a>
			<?php $is_displayed = true; ?>
		<?php endif; ?>
		<?php if ( $show_login_button ) : ?>
			<a href="<?php echo esc_url( wp_login_url() ); ?>" class="stag-button stag-button--normal stag-button--<?php echo esc_attr( $button_color ); ?>"><?php esc_html_e( 'Login', 'ink-assistant' ); ?></a>
		<?php endif; ?>
	</div>

	<?php

	return ob_get_clean();
}
add_shortcode( 'locked_options', 'stag_rcp_locked_options' );
