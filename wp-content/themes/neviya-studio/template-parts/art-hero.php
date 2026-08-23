<?php
/**
 * Hero illustration – pencil line-art layer + colour layer revealed
 * through an organic "ink bleeding into paper" SVG mask.
 *
 * TO REPLACE WITH REAL ARTWORK: keep the two group ids
 * `neviya-hero-lines` (the sketch) and `neviya-hero-color` (the coloured
 * version) and the <mask id="neviya-hero-mask"> exactly as they are –
 * scroll-story.js targets them by id/class. Everything inside those
 * groups can be swapped for real paths exported from Illustrator/Figma.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<svg class="neviya-hero-svg" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="neviyaHeroSvgTitle">
	<title id="neviyaHeroSvgTitle"><?php esc_html_e( 'איור עיפרון של קסת דיו, נביעת קו וצמחייה, ההופך בהדרגה לצבע', 'neviya-studio' ); ?></title>
	<defs>
		<filter id="neviya-bleed" x="-50%" y="-50%" width="200%" height="200%">
			<feTurbulence type="fractalNoise" baseFrequency="0.012" numOctaves="2" seed="7" result="noise"></feTurbulence>
			<feDisplacementMap in="SourceGraphic" in2="noise" scale="46" xChannelSelector="R" yChannelSelector="G"></feDisplacementMap>
		</filter>
		<filter id="neviya-sketchy" x="-20%" y="-20%" width="140%" height="140%">
			<feTurbulence type="fractalNoise" baseFrequency="0.9" numOctaves="2" seed="3" result="n"></feTurbulence>
			<feDisplacementMap in="SourceGraphic" in2="n" scale="3"></feDisplacementMap>
		</filter>
		<radialGradient id="neviya-drop-grad" cx="35%" cy="30%" r="75%">
			<stop offset="0%" stop-color="#bfe3e0"></stop>
			<stop offset="100%" stop-color="#4f7f9e"></stop>
		</radialGradient>
		<linearGradient id="neviya-bottle-grad" x1="0" y1="0" x2="0" y2="1">
			<stop offset="0%" stop-color="#6fa8a3"></stop>
			<stop offset="100%" stop-color="#3a6f7a"></stop>
		</linearGradient>
		<mask id="neviya-hero-mask" maskUnits="userSpaceOnUse" x="0" y="0" width="800" height="800">
			<rect x="0" y="0" width="800" height="800" fill="black"></rect>
			<g class="neviya-reveal-shapes" filter="url(#neviya-bleed)">
				<circle class="neviya-reveal-c1" cx="400" cy="560" r="0" fill="white"></circle>
				<circle class="neviya-reveal-c2" cx="470" cy="480" r="0" fill="white"></circle>
				<circle class="neviya-reveal-c3" cx="330" cy="420" r="0" fill="white"></circle>
			</g>
		</mask>
	</defs>

	<g class="neviya-hero-lines" id="neviya-hero-lines" fill="none" stroke="#3a3a3a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" filter="url(#neviya-sketchy)">
		<path class="neviya-draw-path" pathLength="1" d="M 220 640 C 220 700 300 730 400 730 C 500 730 580 700 580 640 C 580 590 520 560 400 560 C 280 560 220 590 220 640 Z"></path>
		<path class="neviya-draw-path" pathLength="1" d="M 340 560 L 340 470 C 340 440 360 420 400 420 C 440 420 460 440 460 470 L 460 560"></path>
		<path class="neviya-draw-path" pathLength="1" d="M 400 420 C 380 340 420 300 470 250 C 520 200 560 190 600 170"></path>
		<path class="neviya-draw-path" pathLength="1" d="M 470 250 C 430 260 400 240 390 200 C 380 160 400 130 440 120"></path>
		<path class="neviya-draw-path" pathLength="1" d="M 400 420 C 360 360 300 350 250 380 C 210 405 195 445 210 480"></path>
		<path class="neviya-draw-path" pathLength="1" d="M 250 380 C 260 340 240 305 200 295"></path>
		<path class="neviya-draw-path" pathLength="1" d="M 400 420 C 420 360 480 340 540 360 C 580 375 605 405 605 440"></path>
		<circle class="neviya-draw-path" pathLength="1" cx="470" cy="480" r="16"></circle>
		<path class="neviya-draw-path" pathLength="1" d="M 470 464 C 478 470 483 480 478 492 C 473 502 460 502 456 492 C 452 483 460 468 470 464 Z"></path>
	</g>

	<g class="neviya-hero-color" id="neviya-hero-color" mask="url(#neviya-hero-mask)">
		<path d="M 220 640 C 220 700 300 730 400 730 C 500 730 580 700 580 640 C 580 590 520 560 400 560 C 280 560 220 590 220 640 Z" fill="url(#neviya-bottle-grad)"></path>
		<path d="M 400 420 C 380 340 420 300 470 250 C 520 200 560 190 600 170" fill="none" stroke="#7a9b6e" stroke-width="10" stroke-linecap="round"></path>
		<path d="M 470 250 C 430 260 400 240 390 200 C 380 160 400 130 440 120 C 470 150 470 200 445 235 Z" fill="#7a9b6e"></path>
		<path d="M 400 420 C 360 360 300 350 250 380 C 210 405 195 445 210 480 C 250 460 280 420 320 405 Z" fill="#6fa8a3"></path>
		<path d="M 400 420 C 420 360 480 340 540 360 C 580 375 605 405 605 440 C 560 430 520 400 470 400 Z" fill="#d98a4a"></path>
		<circle cx="470" cy="480" r="16" fill="url(#neviya-drop-grad)"></circle>
	</g>
</svg>
