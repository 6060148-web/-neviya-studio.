<?php
/**
 * Elementor integration bootstrap: category + widget registration.
 *
 * Only loaded when Elementor is active (see functions.php), so this
 * file can safely reference \Elementor\* classes at parse time.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A dedicated widget category keeps the five Neviya widgets grouped
 * together in the Elementor panel instead of scattered among "Basic".
 */
function neviya_register_elementor_category( $elements_manager ) {
	$elements_manager->add_category( 'neviya-studio', array(
		'title' => __( 'סטודיו נביעה', 'neviya-studio' ),
		'icon'  => 'eicon-paint-brush',
	) );
}
add_action( 'elementor/elements/categories_registered', 'neviya_register_elementor_category' );

function neviya_register_elementor_widgets( $widgets_manager ) {
	$widget_files = array(
		'class-widget-hero-scene.php',
		'class-widget-about-scene.php',
		'class-widget-domains.php',
		'class-widget-projects-story.php',
		'class-widget-contact.php',
	);

	foreach ( $widget_files as $file ) {
		require_once __DIR__ . '/widgets/' . $file;
	}

	$widgets_manager->register( new \Neviya_Widget_Hero_Scene() );
	$widgets_manager->register( new \Neviya_Widget_About_Scene() );
	$widgets_manager->register( new \Neviya_Widget_Domains() );
	$widgets_manager->register( new \Neviya_Widget_Projects_Story() );
	$widgets_manager->register( new \Neviya_Widget_Contact() );
}
add_action( 'elementor/widgets/register', 'neviya_register_elementor_widgets' );

/**
 * The scroll-story engine (GSAP/ScrollTrigger) is only enqueued for the
 * theme templates in inc/enqueue.php; also load it whenever a page is
 * being edited or rendered with our widgets present, so it still works
 * when an editor drops these widgets onto an arbitrary Elementor page.
 */
function neviya_elementor_needs_story_engine( $needs ) {
	if ( ! did_action( 'elementor/loaded' ) || ! \Elementor\Plugin::$instance->documents->get( get_the_ID() ) ) {
		return $needs;
	}
	$document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
	if ( $document && $document->is_built_with_elementor() ) {
		return true;
	}
	return $needs;
}
add_filter( 'neviya_needs_story_engine', 'neviya_elementor_needs_story_engine' );
