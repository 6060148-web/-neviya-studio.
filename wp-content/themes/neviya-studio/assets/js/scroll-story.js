/**
 * Scroll-story animation engine.
 *
 * Uses GSAP + ScrollTrigger purely as *scroll-linked* animation (scrub /
 * enter-viewport triggers) — never scroll hijacking, never pinning beyond
 * a section's own sticky visual, and every effect has a static, fully
 * visible CSS fallback (see hero.css / about.css / domains.css /
 * projects.css ".neviya-reduced-motion" rules) for prefers-reduced-motion.
 */
( function () {
	'use strict';

	if ( typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' ) {
		return;
	}

	gsap.registerPlugin( ScrollTrigger );

	var reduced = !! window.NEVIYA_REDUCED_MOTION;

	function ready( fn ) {
		if ( document.readyState !== 'loading' ) {
			fn();
		} else {
			document.addEventListener( 'DOMContentLoaded', fn );
		}
	}

	function revealOnEnter( elements, className, start ) {
		elements.forEach( function ( el ) {
			ScrollTrigger.create( {
				trigger: el,
				start: start || 'top 82%',
				once: true,
				onEnter: function () {
					el.classList.add( className );
				},
			} );
		} );
	}

	function initHero() {
		var section = document.getElementById( 'neviya-hero' );
		if ( ! section ) {
			return;
		}

		var svg = section.querySelector( '.neviya-hero-svg' );
		if ( svg ) {
			svg.classList.add( 'neviya-hero-lines-ready' );
		}

		if ( reduced ) {
			return; // CSS already shows the fully revealed, static artwork.
		}

		var c1 = section.querySelector( '.neviya-reveal-c1' );
		var c2 = section.querySelector( '.neviya-reveal-c2' );
		var c3 = section.querySelector( '.neviya-reveal-c3' );
		if ( ! c1 || ! c2 || ! c3 ) {
			return;
		}

		gsap.timeline( {
			scrollTrigger: {
				trigger: section,
				start: 'top top',
				end: 'bottom bottom',
				scrub: 0.6,
			},
		} )
			.fromTo( c1, { attr: { r: 0 } }, { attr: { r: 560 }, ease: 'none' }, 0 )
			.fromTo( c2, { attr: { r: 0 } }, { attr: { r: 460 }, ease: 'none' }, 0.08 )
			.fromTo( c3, { attr: { r: 0 } }, { attr: { r: 420 }, ease: 'none' }, 0.16 );

		var cue = section.querySelector( '.neviya-scroll-cue' );
		if ( cue ) {
			gsap.to( cue, {
				opacity: 0,
				scrollTrigger: { trigger: section, start: 'top top', end: '15% top', scrub: true },
			} );
		}
	}

	function initAbout() {
		var section = document.getElementById( 'neviya-about' );
		if ( ! section ) {
			return;
		}
		var svg = section.querySelector( '.neviya-about-svg' );
		var lines = Array.prototype.slice.call( section.querySelectorAll( '.neviya-about__line' ) );

		ScrollTrigger.create( {
			trigger: section,
			start: 'top 65%',
			once: true,
			onEnter: function () {
				if ( svg ) {
					svg.classList.add( 'is-drawn' );
				}
				lines.forEach( function ( line ) {
					line.classList.add( 'is-visible' );
				} );
			},
		} );
	}

	function initDomains() {
		var section = document.getElementById( 'neviya-domains' );
		if ( ! section ) {
			return;
		}
		var stem = section.querySelector( '.neviya-domains__stem' );
		ScrollTrigger.create( {
			trigger: section,
			start: 'top 60%',
			once: true,
			onEnter: function () {
				if ( stem ) {
					stem.classList.add( 'is-drawn' );
				}
			},
		} );

		revealOnEnter( Array.prototype.slice.call( section.querySelectorAll( '.neviya-domains__item' ) ), 'is-visible' );
	}

	function initProjects() {
		var cards = Array.prototype.slice.call( document.querySelectorAll( '.neviya-project-card' ) );
		revealOnEnter( cards, 'is-visible', 'top 85%' );
	}

	function initVideoPreviews() {
		document.querySelectorAll( '.neviya-video-preview' ).forEach( function ( preview ) {
			var button = preview.querySelector( '.neviya-video-preview__play' );
			if ( ! button ) {
				return;
			}
			button.addEventListener( 'click', function () {
				var embedSrc = preview.getAttribute( 'data-embed-src' );
				var fileSrc = preview.getAttribute( 'data-file-src' );

				if ( embedSrc ) {
					var iframe = document.createElement( 'iframe' );
					iframe.src = embedSrc;
					iframe.title = preview.closest( '[data-neviya-scene]' ) ? document.title : 'video';
					iframe.setAttribute( 'allow', 'autoplay; fullscreen; picture-in-picture' );
					iframe.allowFullscreen = true;
					preview.textContent = '';
					preview.appendChild( iframe );
				} else if ( fileSrc ) {
					var video = document.createElement( 'video' );
					video.src = fileSrc;
					video.controls = true;
					video.autoplay = true;
					video.playsInline = true;
					preview.textContent = '';
					preview.appendChild( video );
				}
			} );
		} );
	}

	ready( function () {
		initHero();
		initAbout();
		initDomains();
		initProjects();
		initVideoPreviews();
	} );
} )();
