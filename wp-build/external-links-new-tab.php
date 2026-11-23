<?php
/**
 * U-Teal · External links open in a new tab (PERMANENT snippet)
 * Paste into wp-admin › Snippets › Add New · type PHP · "Only run on site front-end" · Activate.
 *
 * Every link to another website (http/https, different host) gets target="_blank"
 * and rel="noopener noreferrer", on all pages, posts, case studies, header and footer,
 * including links Nadja adds later. Internal links, #anchors, mailto: and tel: are untouched.
 * www. and non-www are treated as the same site (works before and after go-live).
 */

add_action( 'wp_footer', function () {
	$js = <<<'JS'
(function () {
	var here = location.hostname.replace(/^www\./, '');
	function mark(root) {
		var links = (root || document).querySelectorAll('a[href^="http"]');
		for (var i = 0; i < links.length; i++) {
			var a = links[i];
			if (a.hostname.replace(/^www\./, '') === here) continue;
			a.setAttribute('target', '_blank');
			var rel = (a.getAttribute('rel') || '').split(/\s+/);
			if (rel.indexOf('noopener') < 0) rel.push('noopener');
			if (rel.indexOf('noreferrer') < 0) rel.push('noreferrer');
			a.setAttribute('rel', rel.join(' ').trim());
		}
	}
	mark(document);
	/* Links added later by scripts (e.g. Elementor popups, loops) */
	if (window.MutationObserver) {
		new MutationObserver(function (list) {
			list.forEach(function (m) {
				m.addedNodes.forEach(function (n) {
					if (n.nodeType === 1) mark(n.parentNode || n);
				});
			});
		}).observe(document.body, { childList: true, subtree: true });
	}
})();
JS;
	wp_print_inline_script_tag( $js, array( 'id' => 'ut-external-links' ) );
}, 99 );
