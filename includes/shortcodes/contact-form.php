<?php
/**
 * Contact Form Shortcode
 *
 * Displays a contact form.
 *
 * @package Ink Assistant
 * @subpackage Ink
 */
function ink_contact_form_sc() {

	$name_error          = __( 'Please enter your name.', 'ink-assistant' );
	$email_error         = __( 'Please enter your email address.', 'ink-assistant' );
	$email_invalid_error = __( 'You entered an invalid email address.', 'ink-assistant' );
	$comment_error       = __( 'Please enter a message.', 'ink-assistant' );

	$error_messages = array();

	if ( isset( $_POST['submitted'] ) ) {

		if ( trim( $_POST['contactName'] ) === '' ) {
			$error_messages['nameError'] = $name_error;
			$has_error                   = true;
		} else {
			$name = trim( $_POST['contactName'] );
		}

		if ( trim( $_POST['email'] ) === '' ) {
			$error_messages['emailError'] = $email_error;
			$has_error                    = true;
		} elseif ( ! is_email( trim( $_POST['email'] ) ) ) {
			$error_messages['emailInvalidError'] = $email_invalid_error;
			$has_error                           = true;
		} else {
			$email = trim( $_POST['email'] );
		}

		if ( trim( $_POST['comments'] ) === '' ) {
			$error_messages['commentError'] = $comment_error;
			$has_error                      = true;
		} else {
			$comments = stripslashes( trim( $_POST['comments'] ) );
		}

		if ( ! isset( $has_error ) ) {
			$email_to = stag_theme_mod( 'general_settings', 'contact_email' );

			if ( ! isset( $email_to ) || ( $email_to == '' ) ) {
				$email_to = get_option( 'admin_email' );
			}

			$subject = '[Contact Form] From ' . $name;
			$body    = "Name: $name \n\nEmail: $email \n\nMessage: $comments \n\n";
			$body   .= "--\n";
			$body   .= 'This mail is sent via contact form on ' . get_bloginfo( 'name' ) . "\n";
			$body   .= home_url();
			$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n" . 'Reply-To: ' . $email;

			wp_mail( $email_to, $subject, $body, $headers );
			$email_sent = true;
		}
	}

	?>

	<section class="ink-contact-form">
		<?php if ( isset( $email_sent ) && true === $email_sent ) : ?>

		<div class="stag-alert stag-alert--green">
			<p><?php esc_html_e( 'Thanks, your email was sent successfully.', 'ink-assistant' ); ?></p>
		</div>

		<?php else : ?>

		<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
			<h2 class="ink-contact-form__title"><?php esc_html_e( 'Send a Message', 'ink-assistant' ); ?></h2>

			<div class="grid">
				<p class="unit one-of-two">
					<label for="contactName"><?php esc_html_e( 'Name', 'ink-assistant' ); ?></label>
					<input type="text" name="contactName" id="contactName" value="
					<?php
					if ( isset( $_POST['contactName'] ) ) {
						echo esc_attr( $_POST['contactName'] );}
					?>
					" required>
					<?php if ( isset( $error_messages['nameError'] ) ) { ?>
						<span class="error"><?php echo esc_html( $error_messages['nameError'] ); ?></span>
					<?php } ?>
				</p>

				<p class="unit one-of-two">
					<label for="email"><?php esc_html_e( 'Email', 'ink-assistant' ); ?></label>
					<input type="email" name="email" id="email" value="
					<?php
					if ( isset( $_POST['email'] ) ) {
						echo esc_attr( $_POST['email'] ); }
					?>
					" required>
					<?php if ( isset( $error_messages['emailError'] ) ) { ?>
						<span class="error"><?php echo esc_html( $error_messages['emailError'] ); ?></span>
					<?php } ?>
					<?php if ( isset( $error_messages['emailInvalidError'] ) ) { ?>
						<span class="error"><?php echo esc_html( $error_messages['emailInvalidError'] ); ?></span>
					<?php } ?>
				</p>

				<p class="unit span-grid">
					<label for="commentsText"><?php esc_html_e( 'Your Message', 'ink-assistant' ); ?></label>
					<textarea rows="6" name="comments" id="commentsText" required>
					<?php
					if ( isset( $_POST['comments'] ) ) {
						echo stripslashes( $_POST['comments'] ); }
					?>
					</textarea>
					<?php if ( isset( $error_messages['commentError'] ) ) { ?>
						<span class="error"><?php echo esc_html( $error_messages['commentError'] ); ?></span>
					<?php } ?>
				</p>

			</div>

			<p class="buttons">
				<input type="submit" id="submitted" class="contact-form-button" name="submitted" value="<?php esc_attr_e( 'Send Message', 'ink-assistant' ); ?>">
			</p>

		</form>

		<?php endif; ?>
	</section>

	<?php
}
add_shortcode( 'ink_contact_form', 'ink_contact_form_sc' );
?>
