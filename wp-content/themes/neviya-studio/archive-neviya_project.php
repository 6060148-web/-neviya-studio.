<?php
/**
 * Archive of all projects – a plain, crawlable grid (no scroll-story
 * animation engine here; that lives on the front page / single project).
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="neviya-archive">
	<header class="neviya-archive__header">
		<h1 class="neviya-section-title"><?php esc_html_e( 'כל הפרויקטים', 'neviya-studio' ); ?></h1>
	</header>

	<?php get_template_part( 'template-parts/archive-filters' ); ?>

	<?php if ( have_posts() ) : ?>
		<div class="neviya-archive__grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/project-card', null, array( 'project' => neviya_get_project_data( get_the_ID() ) ) );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'עדיין אין פרויקטים פורסמו.', 'neviya-studio' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
