<?php
/**
 * Neviya Studio – theme bootstrap.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NEVIYA_VERSION', '1.0.0' );
define( 'NEVIYA_DIR', get_template_directory() );
define( 'NEVIYA_URI', get_template_directory_uri() );

require NEVIYA_DIR . '/inc/theme-setup.php';
require NEVIYA_DIR . '/inc/enqueue.php';
require NEVIYA_DIR . '/inc/cpt-projects.php';
require NEVIYA_DIR . '/inc/meta-boxes.php';
require NEVIYA_DIR . '/inc/helpers.php';
require NEVIYA_DIR . '/inc/shortcodes.php';
require NEVIYA_DIR . '/inc/contact-form.php';
require NEVIYA_DIR . '/inc/schema.php';
require NEVIYA_DIR . '/inc/admin.php';
require NEVIYA_DIR . '/inc/domain-icons.php';
require NEVIYA_DIR . '/inc/render-sections.php';
require NEVIYA_DIR . '/inc/customizer.php';
require NEVIYA_DIR . '/inc/demo-content.php';

/**
 * Load Elementor integration only when Elementor is active,
 * so nothing here fatal-errors a site running without it.
 */
add_action( 'plugins_loaded', 'neviya_load_elementor_integration' );
function neviya_load_elementor_integration() {
	if ( did_action( 'elementor/loaded' ) ) {
		require NEVIYA_DIR . '/elementor/class-neviya-elementor.php';
	}
}
