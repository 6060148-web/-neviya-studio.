<?php
/**
 * Contact form AJAX handler.
 *
 * Handles both logged-in and logged-out visitors via wp_ajax_nopriv,
 * validates a nonce and an invisible honeypot field, sanitizes every
 * input, and sends the enquiry by e-mail to the studio.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function neviya_handle_contact_form() {
	check_ajax_referer( 'neviya_contact_form', 'nonce' );

	// Honeypot: real visitors never fill this hidden field.
	if ( ! empty( $_POST['neviya_website'] ) ) {
		wp_send_json_success( array( 'message' => __( 'תודה!', 'neviya-studio' ) ) );
	}

	$name     = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$contact  = isset( $_POST['contact'] ) ? sanitize_text_field( wp_unslash( $_POST['contact'] ) ) : '';
	$type     = isset( $_POST['project_type'] ) ? sanitize_text_field( wp_unslash( $_POST['project_type'] ) ) : '';
	$message  = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$consent  = isset( $_POST['consent'] ) && '1' === $_POST['consent'];

	if ( '' === $name || '' === $contact || '' === $message || ! $consent ) {
		wp_send_json_error( array(
			'message' => __( 'אנא מלאו את כל השדות הנדרשים ואשרו את מדיניות הפרטיות.', 'neviya-studio' ),
		), 400 );
	}

	$is_email    = is_email( $contact );
	$reply_email = $is_email ? $contact : get_option( 'admin_email' );

	$to      = apply_filters( 'neviya_contact_recipient', get_option( 'admin_email' ) );
	$subject = sprintf( '[%s] פנייה חדשה מהאתר', get_bloginfo( 'name' ) );

	$body  = __( 'התקבלה פנייה חדשה דרך אתר סטודיו נביעה:', 'neviya-studio' ) . "\n\n";
	$body .= __( 'שם:', 'neviya-studio' ) . ' ' . $name . "\n";
	$body .= __( 'פרטי התקשרות:', 'neviya-studio' ) . ' ' . $contact . "\n";
	if ( $type ) {
		$body .= __( 'סוג פרויקט:', 'neviya-studio' ) . ' ' . $type . "\n";
	}
	$body .= "\n" . __( 'הודעה:', 'neviya-studio' ) . "\n" . $message . "\n";

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $is_email ) {
		$headers[] = 'Reply-To: ' . $reply_email;
	}

	$sent = wp_mail( $to, $subject, $body, $headers );

	/**
	 * Persist every enquiry as a private CPT entry too, so nothing is
	 * lost if outgoing mail is misconfigured on the host.
	 */
	wp_insert_post( array(
		'post_type'    => 'neviya_enquiry',
		'post_status'  => 'private',
		'post_title'   => sprintf( '%s – %s', $name, wp_date( 'Y-m-d H:i' ) ),
		'post_content' => $body,
		'meta_input'   => array(
			'_neviya_enquiry_contact' => $contact,
			'_neviya_enquiry_type'    => $type,
		),
	) );

	if ( $sent ) {
		wp_send_json_success( array( 'message' => __( 'ההודעה נשלחה בהצלחה! נחזור אליכם בקרוב.', 'neviya-studio' ) ) );
	}

	wp_send_json_error( array( 'message' => __( 'לא הצלחנו לשלוח את ההודעה כרגע. נסו שוב מאוחר יותר.', 'neviya-studio' ) ), 500 );
}
add_action( 'wp_ajax_neviya_contact_form', 'neviya_handle_contact_form' );
add_action( 'wp_ajax_nopriv_neviya_contact_form', 'neviya_handle_contact_form' );

/**
 * Lightweight private CPT that stores a copy of every enquiry as a
 * mail-delivery safety net. Not publicly queryable or shown in menus.
 */
function neviya_register_enquiry_cpt() {
	register_post_type( 'neviya_enquiry', array(
		'label'              => __( 'פניות מהטופס', 'neviya-studio' ),
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => 'edit.php?post_type=neviya_project',
		'capability_type'    => 'post',
		'supports'           => array( 'title', 'editor' ),
		'has_archive'        => false,
	) );
}
add_action( 'init', 'neviya_register_enquiry_cpt' );
