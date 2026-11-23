<?php
/**
 * U-teal · Privacy setup + legal pages (PERMANENT snippet)
 *
 * Where: wp-admin › Snippets › Add New
 *   Title: "Privacy setup + legal pages"
 *   Type: PHP · Run snippet everywhere · Activate
 *   (Paste everything BELOW the opening "<?php" line.)
 *
 * 1. Google Fonts are served from this server, not from Google
 *    (same as Elementor › Settings › Performance › "Load Google Fonts Locally").
 *    Her privacy policy says: "There is no connection to Google Fonts".
 * 2. [matomo_opt_out] prints nothing while the Matomo plugin is inactive,
 *    so the privacy pages never show the raw shortcode.
 *    2b. German tagline on /de/ pages (Nadja, 23 Nov 2026).
 * 3. Legal pages: sets German as the language of Impressum (382) and
 *    Datenschutz (383), links them to Legal notice (376) and Privacy policy (3)
 *    and publishes them. Runs once (checks the language first).
 */

// 1. Google Fonts locally.
add_filter( 'pre_option_elementor_local_google_fonts', function () {
	return '1';
} );

// 2. Empty fallback for the Matomo opt-out box.
add_action( 'init', function () {
	if ( ! shortcode_exists( 'matomo_opt_out' ) ) {
		add_shortcode( 'matomo_opt_out', '__return_empty_string' );
	}
}, 99 );

// 2b. German tagline (Settings › General holds the English one).
add_filter( 'option_blogdescription', function ( $value ) {
	if ( ! is_admin() && function_exists( 'pll_current_language' ) && 'de' === pll_current_language() ) {
		return 'Systemische Beratung für Hochschulen im Wandel';
	}
	return $value;
}, 99 );

// 3. Legal pages: German language + translations (once).
add_action( 'wp_loaded', function () {
	if ( ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_get_post_language' ) ) {
		return;
	}
	$pairs = array(
		376 => 382, // Legal notice  ↔ Impressum
		3   => 383, // Privacy policy ↔ Datenschutz
	);
	foreach ( $pairs as $en_id => $de_id ) {
		if ( ! get_post( $en_id ) || ! get_post( $de_id ) ) {
			continue;
		}
		if ( 'de' === pll_get_post_language( $de_id ) ) {
			continue; // already done
		}
		pll_set_post_language( $en_id, 'en' );
		pll_set_post_language( $de_id, 'de' );
		pll_save_post_translations( array( 'en' => $en_id, 'de' => $de_id ) );
		if ( 'publish' !== get_post_status( $de_id ) ) {
			wp_update_post( array( 'ID' => $de_id, 'post_status' => 'publish' ) );
		}
	}
} );
