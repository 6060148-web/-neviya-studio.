<?php
/**
 * The scroll-story home page. Renders automatically as the site's
 * front page with zero configuration; if an editor instead assigns
 * "מסע גלילה – נביעה" (template-story.php) to a page and sets it as
 * the front page under Settings → Reading, that page can additionally
 * be opened and rearranged in Elementor.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="neviya-story">
	<?php
	neviya_render_hero_section();
	neviya_render_about_section();
	neviya_render_domains_section();
	neviya_render_projects_section();
	neviya_render_contact_section();
	?>
</div>

<?php
get_footer();
