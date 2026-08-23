<?php
/**
 * Single project page — fully server-rendered so search engines and
 * no-JS visitors get the complete project without the scroll animations.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$project = neviya_get_project_data( get_the_ID() );
	?>
	<article class="neviya-single-project">
		<header class="neviya-single-project__header" style="--neviya-project-color: <?php echo esc_attr( $project['lead_color'] ); ?>;">
			<?php neviya_the_project_categories( $project['categories'], 'neviya-single-project__cats' ); ?>
			<h1 class="neviya-single-project__title"><?php echo esc_html( $project['title'] ); ?></h1>
			<?php if ( $project['excerpt'] ) : ?>
				<p class="neviya-single-project__excerpt"><?php echo esc_html( $project['excerpt'] ); ?></p>
			<?php endif; ?>
		</header>

		<?php if ( $project['cover_id'] ) : ?>
			<div class="neviya-single-project__cover">
				<?php neviya_the_image( $project['cover_id'], 'neviya-cover', 'neviya-single-project__cover-img', $project['title'], true ); ?>
			</div>
		<?php endif; ?>

		<div class="neviya-single-project__layout">
			<div class="neviya-single-project__content">
				<?php echo wp_kses_post( $project['content'] ); ?>

				<?php if ( $project['video_url'] ) : ?>
					<div class="neviya-single-project__video">
						<?php get_template_part( 'template-parts/media-video', null, array( 'project' => $project ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $project['gallery_ids'] ) ) : ?>
					<div class="neviya-single-project__gallery">
						<?php foreach ( $project['gallery_ids'] as $image_id ) : ?>
							<?php neviya_the_image( $image_id, 'neviya-gallery', 'neviya-single-project__gallery-img', $project['title'] ); ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<aside class="neviya-single-project__sidebar">
				<?php if ( $project['client'] ) : ?>
					<div class="neviya-single-project__fact">
						<h2><?php esc_html_e( 'לקוח', 'neviya-studio' ); ?></h2>
						<p><?php echo esc_html( $project['client'] ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( $project['year'] ) : ?>
					<div class="neviya-single-project__fact">
						<h2><?php esc_html_e( 'שנה', 'neviya-studio' ); ?></h2>
						<p><?php echo esc_html( $project['year'] ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( ! empty( $project['services'] ) ) : ?>
					<div class="neviya-single-project__fact">
						<h2><?php esc_html_e( 'שירותים', 'neviya-studio' ); ?></h2>
						<ul>
							<?php foreach ( $project['services'] as $service ) : ?>
								<li><?php echo esc_html( $service ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<?php if ( $project['external_url'] ) : ?>
					<a class="neviya-btn" href="<?php echo esc_url( $project['external_url'] ); ?>" target="_blank" rel="noopener noreferrer">
						<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H4M10 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
						<span><?php echo esc_html( $project['button_text'] ); ?></span>
					</a>
				<?php endif; ?>
			</aside>
		</div>

		<nav class="neviya-single-project__back">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'neviya_project' ) ); ?>">
				<?php esc_html_e( 'לכל הפרויקטים', 'neviya-studio' ); ?> ←
			</a>
		</nav>
	</article>
	<?php
endwhile;

get_footer();
