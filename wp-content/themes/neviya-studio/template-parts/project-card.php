<?php
/**
 * One project "chapter" inside the scroll story.
 *
 * Expects $args['project'] – the array built by neviya_get_project_data().
 * The visual treatment (data-reveal) is picked per-project via the
 * "סגנון חשיפה" field, so pacing varies without random one-off code.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$project = isset( $args['project'] ) ? $args['project'] : array();
if ( empty( $project ) ) {
	return;
}

$reveal   = $project['reveal_style'];
$has_pair = $project['sketch_id'] && $project['color_id'];
?>
<article
	class="neviya-project-card neviya-project-card--<?php echo esc_attr( $reveal ); ?>"
	data-neviya-scene="project"
	data-reveal="<?php echo esc_attr( $reveal ); ?>"
	style="--neviya-project-color: <?php echo esc_attr( $project['lead_color'] ); ?>;"
>
	<div class="neviya-project-card__media">
		<?php if ( 'video' === $reveal && $project['video_url'] ) : ?>
			<?php get_template_part( 'template-parts/media-video', null, array( 'project' => $project ) ); ?>

		<?php elseif ( 'browser' === $reveal ) : ?>
			<div class="neviya-browser-frame">
				<div class="neviya-browser-frame__bar"><span></span><span></span><span></span></div>
				<div class="neviya-browser-frame__screen">
					<?php neviya_the_image( $project['cover_id'], 'neviya-cover', 'neviya-project-card__img', $project['title'] ); ?>
				</div>
			</div>

		<?php elseif ( 'logo' === $reveal && $has_pair ) : ?>
			<div class="neviya-logo-reveal">
				<?php neviya_the_image( $project['sketch_id'], 'neviya-cover', 'neviya-logo-reveal__sketch', $project['title'] . ' – סקיצה' ); ?>
				<?php neviya_the_image( $project['color_id'], 'neviya-cover', 'neviya-logo-reveal__final', $project['title'] . ' – סמל סופי' ); ?>
			</div>

		<?php elseif ( 'paper' === $reveal ) : ?>
			<div class="neviya-paper-slide">
				<?php neviya_the_image( $project['cover_id'], 'neviya-cover', 'neviya-paper-slide__img', $project['title'] ); ?>
			</div>

		<?php elseif ( $has_pair ) : ?>
			<div class="neviya-mask-reveal">
				<?php neviya_the_image( $project['sketch_id'], 'neviya-cover', 'neviya-mask-reveal__sketch', $project['title'] . ' – סקיצה' ); ?>
				<?php neviya_the_image( $project['color_id'], 'neviya-cover', 'neviya-mask-reveal__color', $project['title'] ); ?>
			</div>

		<?php else : ?>
			<div class="neviya-mask-reveal neviya-mask-reveal--simple">
				<?php if ( $project['cover_id'] ) : ?>
					<?php neviya_the_image( $project['cover_id'], 'neviya-cover', 'neviya-mask-reveal__color', $project['title'] ); ?>
				<?php else : ?>
					<div class="neviya-project-card__placeholder" aria-hidden="true">
						<span><?php echo esc_html( mb_substr( $project['title'], 0, 1 ) ); ?></span>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="neviya-project-card__info">
		<?php neviya_the_project_categories( $project['categories'], 'neviya-project-card__cats' ); ?>
		<h3 class="neviya-project-card__title">
			<a href="<?php echo esc_url( $project['permalink'] ); ?>"><?php echo esc_html( $project['title'] ); ?></a>
		</h3>
		<?php if ( $project['excerpt'] ) : ?>
			<p class="neviya-project-card__excerpt"><?php echo esc_html( $project['excerpt'] ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $project['services'] ) ) : ?>
			<ul class="neviya-project-card__services">
				<?php foreach ( $project['services'] as $service ) : ?>
					<li><?php echo esc_html( $service ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( $project['client'] || $project['year'] ) : ?>
			<p class="neviya-project-card__meta">
				<?php if ( $project['client'] ) : ?><span><?php echo esc_html( $project['client'] ); ?></span><?php endif; ?>
				<?php if ( $project['year'] ) : ?><span><?php echo esc_html( $project['year'] ); ?></span><?php endif; ?>
			</p>
		<?php endif; ?>

		<div class="neviya-project-card__actions">
			<a class="neviya-btn" href="<?php echo esc_url( $project['permalink'] ); ?>">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H4M10 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				<span><?php echo esc_html( $project['button_text'] ); ?></span>
			</a>
			<?php if ( $project['external_url'] ) : ?>
				<a class="neviya-btn neviya-btn--ghost" href="<?php echo esc_url( $project['external_url'] ); ?>" target="_blank" rel="noopener noreferrer">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H4M10 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<span><?php esc_html_e( 'לאתר הפרויקט', 'neviya-studio' ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</article>
