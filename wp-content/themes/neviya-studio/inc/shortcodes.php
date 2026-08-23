<?php
/**
 * Shortcode fallbacks – every section works from a shortcode on any
 * page even without Elementor, using the same renderers as the
 * built-in front page and the Elementor widgets.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function neviya_shortcode_hero( $atts ) {
	$atts = shortcode_atts( array( 'title' => '', 'subtitle' => '' ), $atts, 'neviya_hero' );
	$args = array_filter( $atts );
	ob_start();
	neviya_render_hero_section( $args );
	return ob_get_clean();
}
add_shortcode( 'neviya_hero', 'neviya_shortcode_hero' );

function neviya_shortcode_about( $atts ) {
	$atts = shortcode_atts( array( 'title' => '' ), $atts, 'neviya_about' );
	$args = array_filter( $atts );
	ob_start();
	neviya_render_about_section( $args );
	return ob_get_clean();
}
add_shortcode( 'neviya_about', 'neviya_shortcode_about' );

function neviya_shortcode_domains( $atts ) {
	$atts = shortcode_atts( array( 'title' => '' ), $atts, 'neviya_domains' );
	$args = array_filter( $atts );
	ob_start();
	neviya_render_domains_section( $args );
	return ob_get_clean();
}
add_shortcode( 'neviya_domains', 'neviya_shortcode_domains' );

function neviya_shortcode_projects( $atts ) {
	$atts = shortcode_atts( array(
		'title'    => '',
		'category' => '',
		'featured' => '',
		'count'    => 6,
	), $atts, 'neviya_projects' );

	$args = array(
		'category' => $atts['category'],
		'featured' => '' !== $atts['featured'] ? filter_var( $atts['featured'], FILTER_VALIDATE_BOOLEAN ) : true,
		'count'    => (int) $atts['count'],
	);
	if ( $atts['title'] ) {
		$args['title'] = $atts['title'];
	}
	ob_start();
	neviya_render_projects_section( $args );
	return ob_get_clean();
}
add_shortcode( 'neviya_projects', 'neviya_shortcode_projects' );

function neviya_shortcode_contact( $atts ) {
	$atts = shortcode_atts( array( 'title' => '', 'subtitle' => '' ), $atts, 'neviya_contact' );
	$args = array_filter( $atts );
	ob_start();
	neviya_render_contact_section( $args );
	return ob_get_clean();
}
add_shortcode( 'neviya_contact', 'neviya_shortcode_contact' );
