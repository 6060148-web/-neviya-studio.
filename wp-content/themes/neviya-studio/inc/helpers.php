<?php
/**
 * Front-end helper functions for reading project data.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read one project meta value. Wraps get_post_meta so templates never
 * touch raw meta keys directly, and so an ACF migration later only
 * has to change this one function.
 */
function neviya_get_project_meta( $post_id, $key, $single = true ) {
	if ( function_exists( 'get_field' ) && get_option( 'neviya_use_acf' ) ) {
		return get_field( ltrim( $key, '_' ), $post_id );
	}
	return get_post_meta( $post_id, $key, $single );
}

/**
 * Assemble a full, template-ready data set for one project post.
 */
function neviya_get_project_data( $post_id ) {
	$gallery_raw = neviya_get_project_meta( $post_id, '_neviya_gallery_ids' );
	$gallery_ids = $gallery_raw ? array_filter( array_map( 'absint', explode( ',', $gallery_raw ) ) ) : array();

	$services_raw = (string) neviya_get_project_meta( $post_id, '_neviya_services' );
	$services     = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $services_raw ) ) );

	$sketch_id = absint( neviya_get_project_meta( $post_id, '_neviya_sketch_image_id' ) );
	$color_id  = absint( neviya_get_project_meta( $post_id, '_neviya_color_image_id' ) );

	$categories = get_the_terms( $post_id, 'neviya_project_category' );
	if ( ! is_array( $categories ) ) {
		$categories = array();
	}

	return array(
		'id'            => $post_id,
		'title'         => get_the_title( $post_id ),
		'permalink'     => get_permalink( $post_id ),
		'excerpt'       => has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : wp_trim_words( get_post_field( 'post_content', $post_id ), 26 ),
		'content'       => apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) ),
		'cover_id'      => get_post_thumbnail_id( $post_id ),
		'categories'    => $categories,
		'client'        => neviya_get_project_meta( $post_id, '_neviya_client' ),
		'year'          => neviya_get_project_meta( $post_id, '_neviya_year' ),
		'services'      => $services,
		'lead_color'    => neviya_get_project_meta( $post_id, '_neviya_lead_color' ) ?: '#C85C46',
		'video_url'     => neviya_get_project_meta( $post_id, '_neviya_video_url' ),
		'external_url'  => neviya_get_project_meta( $post_id, '_neviya_external_url' ),
		'button_text'   => neviya_get_project_meta( $post_id, '_neviya_button_text' ) ?: __( 'לצפייה בפרויקט', 'neviya-studio' ),
		'is_featured'   => '1' === neviya_get_project_meta( $post_id, '_neviya_is_featured' ),
		'reveal_style'  => neviya_get_project_meta( $post_id, '_neviya_reveal_style' ) ?: 'mask',
		'sketch_id'     => $sketch_id,
		'color_id'      => $color_id,
		'gallery_ids'   => $gallery_ids,
	);
}

/**
 * Fetch a WP_Query of projects, optionally filtered by category slug
 * and/or limited to featured items. Shared by templates, shortcodes
 * and Elementor widgets so query args never drift apart.
 */
function neviya_get_projects_query( $args = array() ) {
	$defaults = array(
		'category' => '',
		'featured' => false,
		'count'    => -1,
	);
	$args = wp_parse_args( $args, $defaults );

	$query_args = array(
		'post_type'      => 'neviya_project',
		'post_status'    => 'publish',
		'posts_per_page' => $args['count'],
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	);

	if ( $args['category'] ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'neviya_project_category',
				'field'    => 'slug',
				'terms'    => sanitize_title( $args['category'] ),
			),
		);
	}

	if ( $args['featured'] ) {
		$query_args['meta_query'] = array(
			array(
				'key'   => '_neviya_is_featured',
				'value' => '1',
			),
		);
	}

	return new WP_Query( $query_args );
}

/**
 * Meaningful alt text for an attachment: its own alt text first,
 * falling back to the project title so no <img> ships without one.
 */
function neviya_image_alt( $attachment_id, $fallback = '' ) {
	$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
	return $alt ? $alt : $fallback;
}

/**
 * Output a responsive, lazy-loaded <img>. Centralised so every template
 * gets width/height (no layout shift) and loading="lazy" consistently.
 */
function neviya_the_image( $attachment_id, $size = 'neviya-cover', $class = '', $alt_fallback = '', $eager = false ) {
	if ( ! $attachment_id ) {
		return;
	}
	$attrs = array(
		'class'   => $class,
		'alt'     => neviya_image_alt( $attachment_id, $alt_fallback ),
		'loading' => $eager ? 'eager' : 'lazy',
		'decoding' => 'async',
	);
	echo wp_get_attachment_image( $attachment_id, $size, false, $attrs );
}

/**
 * Category term list rendered as accessible pill links, used on cards
 * and single project templates alike.
 */
function neviya_the_project_categories( $categories, $wrap_class = 'neviya-project-cats' ) {
	if ( empty( $categories ) ) {
		return;
	}
	echo '<ul class="' . esc_attr( $wrap_class ) . '">';
	foreach ( $categories as $category ) {
		printf(
			'<li><a href="%1$s">%2$s</a></li>',
			esc_url( get_term_link( $category ) ),
			esc_html( $category->name )
		);
	}
	echo '</ul>';
}
