<?php
/**
 * Quiet video preview: a poster image with a play button. The actual
 * video (YouTube/Vimeo, privacy-enhanced, or a local file) is only
 * loaded into the DOM after a click – see assets/js/scroll-story.js.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$project = isset( $args['project'] ) ? $args['project'] : array();
$url     = $project['video_url'] ?? '';

$embed_src = '';
if ( preg_match( '#youtu\.?be(?:\.com)?/(?:watch\?v=|embed/|)([A-Za-z0-9_-]{6,})#', $url, $m ) ) {
	$embed_src = 'https://www.youtube-nocookie.com/embed/' . rawurlencode( $m[1] ) . '?autoplay=1&rel=0';
} elseif ( preg_match( '#vimeo\.com/(\d+)#', $url, $m ) ) {
	$embed_src = 'https://player.vimeo.com/video/' . rawurlencode( $m[1] ) . '?autoplay=1';
}
$is_file = $url && ! $embed_src && preg_match( '/\.(mp4|webm|ogg)$/i', $url );
?>
<div class="neviya-video-preview" data-embed-src="<?php echo esc_url( $embed_src ); ?>" data-file-src="<?php echo $is_file ? esc_url( $url ) : ''; ?>">
	<?php if ( $project['cover_id'] ) : ?>
		<?php neviya_the_image( $project['cover_id'], 'neviya-cover', 'neviya-video-preview__poster', $project['title'] . ' – תצוגה מקדימה של הסרטון' ); ?>
	<?php else : ?>
		<div class="neviya-video-preview__poster neviya-video-preview__poster--fallback" aria-hidden="true"></div>
	<?php endif; ?>
	<button type="button" class="neviya-video-preview__play" aria-label="<?php esc_attr_e( 'הפעלת הסרטון', 'neviya-studio' ); ?>">
		<svg viewBox="0 0 64 64" aria-hidden="true"><circle cx="32" cy="32" r="30" fill="none" stroke="currentColor" stroke-width="2"/><path d="M26 20 L44 32 L26 44 Z" fill="currentColor"/></svg>
	</button>
</div>
