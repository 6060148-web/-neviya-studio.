<?php
/**
 * Elementor widget: Chapter 3 — Creative domains.
 *
 * The five domains themselves are managed as WordPress taxonomy terms
 * (Projects → תחומי יצירה), not as widget content — this widget only
 * places and titles the section.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Neviya_Widget_Domains extends \Elementor\Widget_Base {

	public function get_name() {
		return 'neviya_domains';
	}

	public function get_title() {
		return __( 'נביעה — תחומי יצירה', 'neviya-studio' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
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
			'default' => __( 'תחומי היצירה', 'neviya-studio' ),
		) );

		$this->add_control( 'terms_note', array(
			'type' => \Elementor\Controls_Manager::RAW_HTML,
			'raw'  => __( 'התחומים עצמם מנוהלים תחת פרויקטים ← תחומי יצירה.', 'neviya-studio' ),
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		neviya_render_domains_section( array( 'title' => $settings['title'] ) );
	}
}
