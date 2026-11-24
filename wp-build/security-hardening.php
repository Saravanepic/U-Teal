<?php
/**
 * U-Teal · Security hardening + clean-up (PERMANENT snippet)
 * Paste into wp-admin › Snippets › Add New · type PHP · "Run snippet everywhere" · Activate.
 *
 * Deliberately NOT done here:
 * - Blocking the whole REST API: the Elementor editor, block editor, Yoast, Code Snippets
 *   and the Elementor MCP connection all need it. Only the user list is closed (below).
 * - Application passwords: may be used by the MCP connection → left on.
 * - HSTS: live since 24 Nov 2026 (section 8); Hostinger "Force HTTPS" is on.
 * XML-RPC is also switched off in Hostinger › WordPress › Security (disable_xml_rpc).
 */

/* 1. Emojis: remove WordPress's emoji script + styles (the browser shows emojis anyway) */
add_action( 'init', function () {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
	remove_action( 'admin_enqueue_scripts', 'wp_enqueue_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
} );
add_filter( 'tiny_mce_plugins', function ( $plugins ) {
	return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : $plugins;
} );
add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'dns-prefetch' === $relation ) {
		$urls = array_filter( $urls, function ( $url ) {
			return false === strpos( is_array( $url ) ? ( $url['href'] ?? '' ) : $url, 's.w.org/images/core/emoji' );
		} );
	}
	return $urls;
}, 10, 2 );

/* 2. <head> clean-up: no version number, RSD/WLW/shortlink, feed links (no blog) */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

/* 3. XML-RPC + pingbacks off (backup for the Hostinger switch) */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'wp_headers', function ( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
} );
add_filter( 'xmlrpc_methods', function ( $methods ) {
	unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );
	return $methods;
} );

/* 4. Hide usernames: no ?author=N / author archives, no user list in the REST API for visitors */
add_action( 'template_redirect', function () {
	if ( is_author() || ( isset( $_GET['author'] ) && ! is_admin() ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}, 1 ); // priority 1: before WordPress's own redirect to /author/<username>/
add_filter( 'rest_endpoints', function ( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		foreach ( array_keys( $endpoints ) as $route ) {
			if ( 0 === strpos( $route, '/wp/v2/users' ) ) {
				unset( $endpoints[ $route ] );
			}
		}
	}
	return $endpoints;
} );
add_filter( 'oembed_response_data', function ( $data ) {
	unset( $data['author_name'], $data['author_url'] );
	return $data;
} );

/* 5. Login: one generic error message (does not reveal whether the username exists) */
add_filter( 'login_errors', function () {
	return 'Login failed. Please check your details and try again.';
} );

/* 6. No theme/plugin file editor in wp-admin (Code Snippets still works) */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/* 7. Comments off everywhere (the site has no comments) */
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'comments_array', '__return_empty_array', 10 );
add_action( 'admin_menu', function () {
	remove_menu_page( 'edit-comments.php' );
} );
add_action( 'admin_bar_menu', function ( $bar ) {
	$bar->remove_node( 'comments' );
}, 999 );

/* 8. Security headers (front end). HSTS added 24 Nov 2026 after the www certificate was fixed.
   1 year, no includeSubDomains (mta-sts and other subdomains are managed elsewhere), no preload. */
add_action( 'send_headers', function () {
	if ( is_admin() ) {
		return;
	}
	if ( is_ssl() ) {
		header( 'Strict-Transport-Security: max-age=31536000' );
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()' );
	header_remove( 'X-Powered-By' );
} );
