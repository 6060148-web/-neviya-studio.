<?php
/**
 * Small hand-drawn glyphs for the five creative domains.
 *
 * Kept as one lookup so the domains section stays a flowing
 * illustration instead of five identical generic icon cards.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function neviya_domain_icon( $slug ) {
	$icons = array(
		'branding-campaigns' => '<svg viewBox="0 0 64 64" aria-hidden="true"><circle cx="30" cy="32" r="20" fill="none" stroke="currentColor" stroke-width="2.5"/><circle cx="30" cy="32" r="12" fill="none" stroke="currentColor" stroke-width="2.5"/><circle cx="30" cy="32" r="4" class="neviya-icon-accent" fill="#c85c46"/><path d="M46 16 L54 8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>',
		'logos-visual-language' => '<svg viewBox="0 0 64 64" aria-hidden="true"><path d="M32 10 L52 44 L12 44 Z" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/><circle cx="32" cy="38" r="10" class="neviya-icon-accent" fill="#6fa8a3" opacity="0.85"/></svg>',
		'digital-ads' => '<svg viewBox="0 0 64 64" aria-hidden="true"><rect x="8" y="12" width="48" height="36" rx="3" fill="none" stroke="currentColor" stroke-width="2.5"/><rect x="14" y="18" width="18" height="14" rx="2" class="neviya-icon-accent" fill="#d98a4a" opacity="0.85"/><path d="M36 20 H50 M36 26 H50 M14 38 H50" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
		'video-motion' => '<svg viewBox="0 0 64 64" aria-hidden="true"><rect x="8" y="14" width="48" height="34" rx="6" fill="none" stroke="currentColor" stroke-width="2.5"/><path d="M27 24 L40 31 L27 38 Z" class="neviya-icon-accent" fill="#4f7f9e"/><path d="M4 20 C 2 26 2 34 4 40" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.6"/><path d="M60 20 C 62 26 62 34 60 40" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.6"/></svg>',
		'websites-landing-pages' => '<svg viewBox="0 0 64 64" aria-hidden="true"><rect x="8" y="12" width="48" height="38" rx="4" fill="none" stroke="currentColor" stroke-width="2.5"/><path d="M8 22 H56" stroke="currentColor" stroke-width="2.5"/><circle cx="14" cy="17" r="1.6" fill="currentColor"/><circle cx="19" cy="17" r="1.6" fill="currentColor"/><circle cx="24" cy="17" r="1.6" fill="currentColor"/><rect x="14" y="28" width="16" height="14" class="neviya-icon-accent" fill="#7a9b6e" opacity="0.85"/><path d="M36 29 H50 M36 35 H50 M36 41 H46" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	);

	if ( isset( $icons[ $slug ] ) ) {
		return $icons[ $slug ];
	}

	return '<svg viewBox="0 0 64 64" aria-hidden="true"><circle cx="32" cy="32" r="20" fill="none" stroke="currentColor" stroke-width="2.5"/></svg>';
}
