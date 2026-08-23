<?php
/**
 * Elementor widget: Chapter 2 — About scene.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Neviya_Widget_About_Scene extends \Elementor\Widget_Base {

	public function get_name() {
		return 'neviya_about_scene';
	}

	public function get_title() {
		return __( 'נביעה — על הסטודיו', 'neviya-studio' );
	}

	public function get_icon() {
		return 'eicon-flow';
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
			'default' => __( 'על הסטודיו — מהרעיון לצורה', 'neviya-studio' ),
		) );

		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'line_text', array(
			'label'       => __( 'משפט', 'neviya-studio' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'default'     => '',
			'show_label'  => false,
			'placeholder' => __( 'הקלידו משפט קצר...', 'neviya-studio' ),
		) );

		$this->add_control( 'lines', array(
			'label'       => __( 'משפטים (נחשפים אחד אחרי השני בגלילה)', 'neviya-studio' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => array(
				array( 'line_text' => __( 'כל פרויקט מתחיל באותו מקום: קו דק, מחשבה לא גמורה, רעיון שעוד לא יודע איך הוא נראה.', 'neviya-studio' ) ),
				array( 'line_text' => __( 'אנחנו בסטודיו נביעה מלווים אותו מהסקיצה הראשונה ועד לשפה חזותית שלמה.', 'neviya-studio' ) ),
				array( 'line_text' => __( 'לא מייצרים תבניות. מקשיבים לרעיון, ונותנים לו לנבוע לצורה שמתאימה רק לו.', 'neviya-studio' ) ),
			),
			'title_field' => '{{{ line_text }}}',
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$lines    = array();
		foreach ( (array) $settings['lines'] as $item ) {
			if ( ! empty( $item['line_text'] ) ) {
				$lines[] = $item['line_text'];
			}
		}

		$args = array( 'title' => $settings['title'] );
		if ( $lines ) {
			$args['lines'] = $lines;
		}

		neviya_render_about_section( $args );
	}
}
