<?php
/**
 * JSON-LD structured data: ProfessionalService site-wide, CreativeWork per project.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function neviya_output_schema() {
	if ( is_front_page() ) {
		$data = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'ProfessionalService',
			'name'        => get_bloginfo( 'name' ) ?: 'סטודיו נביעה',
			'description' => __( 'סטודיו נביעה – עיצוב ושיווק גרפי ודיגיטלי: מיתוג, קמפיינים, לוגואים, וידאו ומושן, אתרים ודפי נחיתה.', 'neviya-studio' ),
			'url'         => home_url( '/' ),
			'image'       => get_site_icon_url(),
			'areaServed'  => 'IL',
			'sameAs'      => array_values( array_filter( array(
				get_theme_mod( 'neviya_social_instagram', '' ),
				get_theme_mod( 'neviya_social_facebook', '' ),
				get_theme_mod( 'neviya_social_linkedin', '' ),
			) ) ),
		);
		neviya_print_schema( $data );
	}

	if ( is_singular( 'neviya_project' ) ) {
		$project = neviya_get_project_data( get_the_ID() );
		$data    = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'CreativeWork',
			'name'        => $project['title'],
			'description' => wp_strip_all_tags( $project['excerpt'] ),
			'url'         => $project['permalink'],
			'creator'     => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ) ?: 'סטודיו נביעה',
			),
		);
		if ( $project['cover_id'] ) {
			$data['image'] = wp_get_attachment_image_url( $project['cover_id'], 'neviya-cover' );
		}
		if ( $project['client'] ) {
			$data['about'] = $project['client'];
		}
		if ( $project['year'] ) {
			$data['dateCreated'] = $project['year'];
		}
		if ( ! empty( $project['categories'] ) ) {
			$data['genre'] = wp_list_pluck( $project['categories'], 'name' );
		}
		neviya_print_schema( $data );
	}
}
add_action( 'wp_head', 'neviya_output_schema' );

function neviya_print_schema( $data ) {
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
