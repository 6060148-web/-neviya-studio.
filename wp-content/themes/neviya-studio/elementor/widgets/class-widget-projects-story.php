<?php
/**
 * Elementor widget: Chapter 4 — Projects, pulled dynamically from WordPress.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Neviya_Widget_Projects_Story extends \Elementor\Widget_Base {

	public function get_name() {
		return 'neviya_projects_story';
	}

	public function get_title() {
		return __( 'נביעה — פרויקטים נבחרים', 'neviya-studio' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
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
			'default' => __( 'פרויקטים נבחרים', 'neviya-studio' ),
		) );

		$category_options = array( '' => __( 'כל התחומים', 'neviya-studio' ) );
		$terms            = get_terms( array( 'taxonomy' => 'neviya_project_category', 'hide_empty' => false ) );
		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				$category_options[ $term->slug ] = $term->name;
			}
		}

		$this->add_control( 'category', array(
			'label'   => __( 'סינון לפי תחום', 'neviya-studio' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => $category_options,
			'default' => '',
		) );

		$this->add_control( 'featured_only', array(
			'label'        => __( 'הצג רק פרויקטים נבחרים', 'neviya-studio' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'כן', 'neviya-studio' ),
			'label_off'    => __( 'לא', 'neviya-studio' ),
			'return_value' => 'yes',
			'default'      => 'yes',
			'description'  => __( 'אם אין פרויקטים המסומנים כ"נבחר", יוצגו כל הפרויקטים.', 'neviya-studio' ),
		) );

		$this->add_control( 'count', array(
			'label'   => __( 'מספר פרויקטים להצגה', 'neviya-studio' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'default' => 6,
			'min'     => 1,
			'max'     => 30,
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		neviya_render_projects_section( array(
			'title'    => $settings['title'],
			'category' => $settings['category'],
			'featured' => 'yes' === $settings['featured_only'],
			'count'    => (int) $settings['count'],
		) );
	}
}
