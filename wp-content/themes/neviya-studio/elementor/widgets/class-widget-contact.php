<?php
/**
 * Elementor widget: Chapter 5 — Contact.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Neviya_Widget_Contact extends \Elementor\Widget_Base {

	public function get_name() {
		return 'neviya_contact';
	}

	public function get_title() {
		return __( 'נביעה — צור קשר', 'neviya-studio' );
	}

	public function get_icon() {
		return 'eicon-mail';
	}

	public function get_categories() {
		return array( 'neviya-studio' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content_section', array(
			'label' => __( 'תוכן', 'neviya-studio' ),
		) );

		$this->add_control( 'title', array(
			'label'   => __( 'כותרת', 'neviya-studio' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'בואו ניצור משהו שנובע', 'neviya-studio' ),
		) );

		$this->add_control( 'subtitle', array(
			'label'   => __( 'טקסט הזמנה', 'neviya-studio' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => __( 'יש לכם רעיון שמחכה לנבוע? ספרו לנו עליו — נשמח לחשוב יחד איך הוא הופך לשפה חזותית.', 'neviya-studio' ),
		) );

		$this->add_control( 'email', array(
			'label'       => __( 'אימייל (ריק = לפי הגדרות ← פרטי קשר)', 'neviya-studio' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => get_theme_mod( 'neviya_contact_email', get_option( 'admin_email' ) ),
		) );

		$this->add_control( 'phone', array(
			'label'       => __( 'טלפון (ריק = לפי הגדרות ← פרטי קשר)', 'neviya-studio' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => get_theme_mod( 'neviya_contact_phone', '' ),
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$args     = array( 'title' => $settings['title'], 'subtitle' => $settings['subtitle'] );
		if ( $settings['email'] ) {
			$args['email'] = $settings['email'];
		}
		if ( $settings['phone'] ) {
			$args['phone'] = $settings['phone'];
		}
		neviya_render_contact_section( $args );
	}
}
