<?php
/**
 * Template Name: מסע גלילה – נביעה
 * Template Post Type: page
 *
 * Assignable page template with the same scroll story as front-page.php.
 * If the page content is edited with Elementor, Elementor's own content
 * (built from the Neviya widgets) is rendered instead of the static
 * PHP sections below, so an editor can freely rearrange chapters.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$post_id           = get_the_ID();
$edited_with_elementor = did_action( 'elementor/loaded' ) && \Elementor\Plugin::$instance->documents->get( $post_id )->is_built_with_elementor();
?>

<div class="neviya-story">
	<?php if ( $edited_with_elementor ) : ?>
		<?php the_content(); ?>
	<?php else : ?>
		<?php
		neviya_render_hero_section();
		neviya_render_about_section();
		neviya_render_domains_section();
		neviya_render_projects_section();
		neviya_render_contact_section();
		?>
	<?php endif; ?>
</div>

<?php
get_footer();
