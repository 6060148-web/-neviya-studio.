/**
 * Site-wide baseline JS: reduced-motion flag + pausing off-screen video.
 * Loaded on every page; the heavier scroll-story engine is not.
 */
( function () {
	'use strict';

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	document.documentElement.classList.toggle( 'neviya-reduced-motion', reduced );
	window.NEVIYA_REDUCED_MOTION = reduced;

	function ready( fn ) {
		if ( document.readyState !== 'loading' ) {
			fn();
		} else {
			document.addEventListener( 'DOMContentLoaded', fn );
		}
	}

	ready( function () {
		if ( ! ( 'IntersectionObserver' in window ) ) {
			return;
		}

		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					var video = entry.target;
					if ( ! entry.isIntersecting && ! video.paused ) {
						video.pause();
					}
				} );
			},
			{ threshold: 0.1 }
		);

		function observeVideos() {
			document.querySelectorAll( 'video' ).forEach( function ( video ) {
				observer.observe( video );
			} );
		}

		observeVideos();

		// Video previews are swapped into the DOM after a click (scroll-story.js);
		// re-scan so those newly-added <video> elements get observed too.
		if ( 'MutationObserver' in window ) {
			new MutationObserver( observeVideos ).observe( document.body, { childList: true, subtree: true } );
		}
	} );
} )();
