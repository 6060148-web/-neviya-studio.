<?php
/**
 * A single flowing line that draws itself across the "About" section
 * as the visitor scrolls – the studio's line of thought taking shape.
 *
 * TO REPLACE: keep the `neviya-draw-path` class and `pathLength="1"`
 * attribute on any path you swap in; scroll-story.js animates its
 * stroke-dashoffset generically based on those.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<svg class="neviya-about-svg" viewBox="0 0 1200 300" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
	<path class="neviya-draw-path" pathLength="1" d="M 10 150 C 150 40 260 260 400 150 C 500 70 560 230 660 150 C 760 70 840 230 940 150 C 1020 90 1080 190 1190 130" fill="none" stroke="#3a3a3a" stroke-width="3" stroke-linecap="round"></path>
	<circle class="neviya-draw-path neviya-about-dot" pathLength="1" cx="1190" cy="130" r="7" fill="#c85c46"></circle>
</svg>
