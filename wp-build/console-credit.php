<?php
/**
 * U-Teal · Developer credit in the browser console (PERMANENT snippet)
 * Paste into wp-admin › Snippets › Add New · type PHP · "Only run on site front-end" · Activate.
 * Shows once per page load in DevTools › Console. No effect on the visible page.
 */

add_action( 'wp_footer', function () {
	$js = 'console.log("%cSite developed by Saravan%c\n%chttps://saravan.dev/",'
		. '"font:700 15px/1.4 system-ui,sans-serif;color:#02383E;",'
		. '"",'
		. '"font:500 13px/1.4 system-ui,sans-serif;color:#008080;");';
	wp_print_inline_script_tag( $js, array( 'id' => 'ut-dev-credit' ) );
}, 100 );
