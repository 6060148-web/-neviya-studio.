<?php
/**
 * Customizer settings for contact details and social links – small,
 * site-wide values that don't belong on any one project or page.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function neviya_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'neviya_contact_section', array(
		'title'    => __( 'פרטי קשר – נביעה', 'neviya-studio' ),
		'priority' => 30,
	) );

	$fields = array(
		'neviya_contact_email' => array( __( 'אימייל ליצירת קשר', 'neviya-studio' ), 'sanitize_email' ),
		'neviya_contact_phone' => array( __( 'טלפון', 'neviya-studio' ), 'sanitize_text_field' ),
		'neviya_social_instagram' => array( __( 'קישור לאינסטגרם', 'neviya-studio' ), 'esc_url_raw' ),
		'neviya_social_facebook'  => array( __( 'קישור לפייסבוק', 'neviya-studio' ), 'esc_url_raw' ),
		'neviya_social_linkedin'  => array( __( 'קישור ללינקדאין', 'neviya-studio' ), 'esc_url_raw' ),
	);

	foreach ( $fields as $id => $field ) {
		list( $label, $sanitize ) = $field;
		$wp_customize->add_setting( $id, array(
			'default'           => '',
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $label,
			'section' => 'neviya_contact_section',
			'type'    => 'text',
		) );
	}
}
add_action( 'customize_register', 'neviya_customize_register' );
