<?php
/**
 * U-Teal · German page shells + language switcher (ONE-TIME snippet)
 * Paste into wp-admin › Snippets › Add New · type PHP · "Only run once" · Save and execute once.
 * Needs Polylang with Deutsch (de) added. Safe to run twice: skips pages that already have a German translation
 * and menus that already have a language switcher. Delete the snippet afterwards.
 *
 * 1. For each English page: creates "<name> – DE" (draft) with the German slug, copies the Elementor layout,
 *    sets the language to German and links it to the English page as its translation.
 * 2. Adds Polylang's language switcher (dropdown, language names, hide languages without translation)
 *    to the end of "Main menu" (EN) and "Hauptmenü DE".
 */

$ut_de_run = function () {
	if ( ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_save_post_translations' ) ) {
		return;
	}

	// English page ID => [ German admin title, German slug ]
	$pages = array(
		79  => array( 'About me – DE', 'ueber-mich' ),
		81  => array( 'Methods – DE', 'methoden' ),
		83  => array( 'Contact – DE', 'kontakt' ),
		85  => array( 'Internationalisation – DE', 'internationalisierung' ),
		149 => array( 'Strategy – DE', 'strategieberatung' ),
		151 => array( 'Organisational development – DE', 'organisationsentwicklung' ),
		153 => array( 'Leadership – DE', 'fuehrungskraefteentwicklung' ),
		155 => array( 'Women – DE', 'frauen-in-hochschulfuehrung' ),
		233 => array( 'Case studies – DE', 'referenzen' ),
	);

	$copy_meta = array(
		'_elementor_data',
		'_elementor_edit_mode',
		'_elementor_template_type',
		'_elementor_version',
		'_elementor_pro_version',
		'_elementor_page_settings',
		'_wp_page_template',
	);

	foreach ( $pages as $en_id => $def ) {
		$en = get_post( $en_id );
		if ( ! $en ) {
			continue;
		}
		$translations = pll_get_post_translations( $en_id );
		if ( ! empty( $translations['de'] ) ) {
			continue; // German version already exists
		}
		$de_id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'draft',
			'post_title'   => $def[0],
			'post_name'    => $def[1],
			'post_content' => '',
			'post_author'  => $en->post_author,
		), true );
		if ( is_wp_error( $de_id ) ) {
			continue;
		}
		foreach ( $copy_meta as $key ) {
			$val = get_post_meta( $en_id, $key, true );
			if ( '' === $val || null === $val ) {
				continue;
			}
			update_post_meta( $de_id, $key, is_string( $val ) ? wp_slash( $val ) : $val );
		}
		pll_set_post_language( $de_id, 'de' );
		$translations['en'] = $en_id;
		$translations['de'] = $de_id;
		pll_save_post_translations( $translations );
	}

	// Language switcher in both main menus
	foreach ( array( 'main-menu', 'hauptmenu-de' ) as $menu_slug ) {
		$menu = wp_get_nav_menu_object( $menu_slug );
		if ( ! $menu ) {
			continue;
		}
		$has = false;
		foreach ( (array) wp_get_nav_menu_items( $menu->term_id ) as $item ) {
			if ( '#pll_switcher' === $item->url ) {
				$has = true;
				break;
			}
		}
		if ( $has ) {
			continue;
		}
		$item_id = wp_update_nav_menu_item( $menu->term_id, 0, array(
			'menu-item-title'    => 'Languages',
			'menu-item-url'      => '#pll_switcher',
			'menu-item-type'     => 'custom',
			'menu-item-status'   => 'publish',
			'menu-item-position' => 99,
		) );
		if ( ! is_wp_error( $item_id ) ) {
			update_post_meta( $item_id, '_pll_menu_item', array(
				'hide_if_no_translation' => 1,
				'hide_current'           => 0,
				'force_home'             => 0,
				'show_flags'             => 0,
				'show_names'             => 1,
				'dropdown'               => 1,
			) );
		}
	}
};

if ( did_action( 'wp_loaded' ) ) {
	$ut_de_run();
} else {
	add_action( 'wp_loaded', $ut_de_run, 99 );
}
