<?php
/**
 * Chapter 5 — contact form + studio details + social links.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title    = $args['title'] ?? __( 'בואו ניצור משהו שנובע', 'neviya-studio' );
$subtitle = $args['subtitle'] ?? '';
$email    = $args['email'] ?? get_option( 'admin_email' );
$phone    = $args['phone'] ?? '';

$privacy_url = get_privacy_policy_url();

$socials = array(
	'instagram' => get_theme_mod( 'neviya_social_instagram', '' ),
	'facebook'  => get_theme_mod( 'neviya_social_facebook', '' ),
	'linkedin'  => get_theme_mod( 'neviya_social_linkedin', '' ),
);
$social_labels = array(
	'instagram' => __( 'אינסטגרם', 'neviya-studio' ),
	'facebook'  => __( 'פייסבוק', 'neviya-studio' ),
	'linkedin'  => __( 'לינקדאין', 'neviya-studio' ),
);

$categories = get_terms( array( 'taxonomy' => 'neviya_project_category', 'hide_empty' => false ) );
?>
<section id="neviya-contact" class="neviya-contact" data-neviya-scene="contact" aria-labelledby="neviya-contact-title">
	<div class="neviya-contact__inner">
		<h2 id="neviya-contact-title" class="neviya-section-title"><?php echo esc_html( $title ); ?></h2>
		<?php if ( $subtitle ) : ?>
			<p class="neviya-contact__subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>

		<div class="neviya-contact__grid">
			<form class="neviya-contact-form" id="neviya-contact-form" novalidate>
				<div class="neviya-field">
					<label for="neviya-field-name"><?php esc_html_e( 'שם מלא', 'neviya-studio' ); ?> <span aria-hidden="true">*</span></label>
					<input type="text" id="neviya-field-name" name="name" autocomplete="name" required />
				</div>
				<div class="neviya-field">
					<label for="neviya-field-contact"><?php esc_html_e( 'טלפון או אימייל', 'neviya-studio' ); ?> <span aria-hidden="true">*</span></label>
					<input type="text" id="neviya-field-contact" name="contact" autocomplete="email" required />
				</div>
				<div class="neviya-field">
					<label for="neviya-field-type"><?php esc_html_e( 'סוג הפרויקט', 'neviya-studio' ); ?></label>
					<select id="neviya-field-type" name="project_type">
						<option value=""><?php esc_html_e( 'בחרו תחום (לא חובה)', 'neviya-studio' ); ?></option>
						<?php if ( is_array( $categories ) ) : foreach ( $categories as $cat ) : ?>
							<option value="<?php echo esc_attr( $cat->name ); ?>"><?php echo esc_html( $cat->name ); ?></option>
						<?php endforeach; endif; ?>
						<option value="<?php esc_attr_e( 'אחר', 'neviya-studio' ); ?>"><?php esc_html_e( 'אחר', 'neviya-studio' ); ?></option>
					</select>
				</div>
				<div class="neviya-field">
					<label for="neviya-field-message"><?php esc_html_e( 'ספרו לנו על הרעיון', 'neviya-studio' ); ?> <span aria-hidden="true">*</span></label>
					<textarea id="neviya-field-message" name="message" rows="4" required></textarea>
				</div>

				<p class="neviya-field neviya-field--consent">
					<label>
						<input type="checkbox" name="consent" value="1" required />
						<?php if ( $privacy_url ) : ?>
							<?php
							printf(
								/* translators: %s: link to the privacy policy page */
								esc_html__( 'קראתי ואני מסכימ/ה ל%s', 'neviya-studio' ),
								'<a href="' . esc_url( $privacy_url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'מדיניות הפרטיות', 'neviya-studio' ) . '</a>'
							);
							?>
						<?php else : ?>
							<?php esc_html_e( 'אני מסכימ/ה שהפרטים שמסרתי ישמשו ליצירת קשר בלבד.', 'neviya-studio' ); ?>
						<?php endif; ?>
					</label>
				</p>

				<div class="neviya-honeypot" aria-hidden="true">
					<label for="neviya-website">Website</label>
					<input type="text" id="neviya-website" name="neviya_website" tabindex="-1" autocomplete="off" />
				</div>

				<button type="submit" class="neviya-btn neviya-btn--submit">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H4M10 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<span class="neviya-btn__label"><?php esc_html_e( 'שליחה', 'neviya-studio' ); ?></span>
				</button>

				<p class="neviya-contact-form__status" role="status" aria-live="polite"></p>
			</form>

			<div class="neviya-contact__details">
				<?php if ( $email ) : ?>
					<a class="neviya-contact__detail" href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
				<?php endif; ?>
				<?php if ( $phone ) : ?>
					<a class="neviya-contact__detail" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
				<?php endif; ?>

				<?php if ( array_filter( $socials ) ) : ?>
					<ul class="neviya-social-links">
						<?php foreach ( $socials as $key => $link ) :
							if ( ! $link ) {
								continue;
							}
							?>
							<li><a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $social_labels[ $key ] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
