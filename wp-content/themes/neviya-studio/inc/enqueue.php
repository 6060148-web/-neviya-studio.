<?php
/**
 * Styles & scripts registration and conditional loading.
 *
 * Heavy animation scripts (GSAP/ScrollTrigger and the scene modules)
 * are only enqueued on templates that actually use scroll storytelling –
 * the front page story and single project pages – never site-wide.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the current request needs the scroll-story animation engine.
 */
function neviya_needs_story_engine() {
	if ( is_front_page() || is_page_template( 'template-story.php' ) || is_singular( 'neviya_project' ) ) {
		return true;
	}
	return (bool) apply_filters( 'neviya_needs_story_engine', false );
}

function neviya_enqueue_assets() {
	$css_files = array( 'variables', 'base', 'hero', 'about', 'domains', 'projects', 'contact', 'responsive' );
	$deps      = array();
	foreach ( $css_files as $file ) {
		$handle = 'neviya-' . $file;
		wp_enqueue_style( $handle, NEVIYA_URI . '/assets/css/' . $file . '.css', $deps, NEVIYA_VERSION );
		$deps[] = $handle;
	}

	wp_enqueue_style(
		'neviya-fonts',
		'https://fonts.googleapis.com/css2?family=Frank+Ruhl+Libre:wght@500;700;900&family=Heebo:wght@300;400;500;700&display=swap',
		array(),
		null
	);

	wp_enqueue_script( 'neviya-main', NEVIYA_URI . '/assets/js/main.js', array(), NEVIYA_VERSION, true );

	if ( neviya_needs_story_engine() ) {
		wp_enqueue_script( 'gsap', NEVIYA_URI . '/assets/js/vendor/gsap.min.js', array(), '3.15.0', true );
		wp_enqueue_script( 'gsap-scrolltrigger', NEVIYA_URI . '/assets/js/vendor/ScrollTrigger.min.js', array( 'gsap' ), '3.15.0', true );
		wp_enqueue_script( 'neviya-scroll-story', NEVIYA_URI . '/assets/js/scroll-story.js', array( 'gsap', 'gsap-scrolltrigger', 'neviya-main' ), NEVIYA_VERSION, true );

		wp_localize_script( 'neviya-scroll-story', 'NeviyaStory', array(
			'reducedMotion' => false,
			'isMobileBreak' => 768,
		) );
	}

	wp_enqueue_script( 'neviya-contact-form', NEVIYA_URI . '/assets/js/contact-form.js', array(), NEVIYA_VERSION, true );
	wp_localize_script( 'neviya-contact-form', 'NeviyaContact', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'neviya_contact_form' ),
		'i18n'    => array(
			'sending' => __( 'שולח…', 'neviya-studio' ),
			'success' => __( 'ההודעה נשלחה בהצלחה! נחזור אליכם בקרוב.', 'neviya-studio' ),
			'error'   => __( 'משהו השתבש. נסו שוב או צרו קשר ישירות במייל.', 'neviya-studio' ),
			'invalid' => __( 'אנא מלאו את כל השדות הנדרשים.', 'neviya-studio' ),
		),
	) );
}
add_action( 'wp_enqueue_scripts', 'neviya_enqueue_assets' );

/**
 * Preconnect to Google Fonts host for a faster first paint.
 */
function neviya_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		$urls[] = 'https://fonts.googleapis.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'neviya_resource_hints', 10, 2 );

/**
 * Defer/async non-critical scripts to avoid render-blocking.
 */
function neviya_script_loader_tag( $tag, $handle ) {
	$defer_handles = array( 'neviya-main', 'gsap', 'gsap-scrolltrigger', 'neviya-scroll-story', 'neviya-contact-form' );
	if ( in_array( $handle, $defer_handles, true ) && false === strpos( $tag, 'defer' ) ) {
		$tag = str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'neviya_script_loader_tag', 10, 2 );
