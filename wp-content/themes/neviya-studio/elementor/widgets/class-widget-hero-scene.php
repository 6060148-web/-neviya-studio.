<?php
/**
 * Elementor widget: Chapter 1 — Hero scene.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Neviya_Widget_Hero_Scene extends \Elementor\Widget_Base {

	public function get_name() {
		return 'neviya_hero_scene';
	}

	public function get_title() {
		return __( 'נביעה — הירו (פתיחה)', 'neviya-studio' );
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	public function get_categories() {
		return array( 'neviya-studio' );
	}

	public function get_keywords() {
		return array( 'neviya', 'hero', 'נביעה', 'הירו' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content_section', array(
			'label' => __( 'תוכן', 'neviya-studio' ),
		) );

		$this->add_control( 'eyebrow', array(
			'label'   => __( 'שורת פתיחה קטנה', 'neviya-studio' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'סטודיו נביעה — עיצוב ושיווק גרפי ודיגיטלי', 'neviya-studio' ),
		) );

		$this->add_control( 'title', array(
			'label'   => __( 'כותרת ראשית', 'neviya-studio' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => __( 'מרעיון קטן נובעת שפה שלמה', 'neviya-studio' ),
		) );

		$this->add_control( 'subtitle', array(
			'label'   => __( 'טקסט משני', 'neviya-studio' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => __( 'אנחנו נותנים לרעיונות צורה, צבע ותנועה: מיתוג, קמפיינים וחוויות דיגיטליות שנוצרו כדי להרגיש.', 'neviya-studio' ),
		) );

		$this->add_control( 'cue', array(
			'label'   => __( 'טקסט סימון גלילה', 'neviya-studio' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'גללו כדי לצפות ברעיון נובע לחיים', 'neviya-studio' ),
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		neviya_render_hero_section( array(
			'eyebrow'  => $settings['eyebrow'],
			'title'    => nl2br( esc_html( $settings['title'] ) ),
			'subtitle' => $settings['subtitle'],
			'cue'      => $settings['cue'],
		) );
	}
}
