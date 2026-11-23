<?php
/**
 * U-teal · Yoast schema additions (Person + Organisation details)
 *
 * Where: wp-admin › Snippets › Add New
 *   Title: "Yoast schema: Person + Organisation details"
 *   Type: PHP · Run snippet everywhere · Activate
 *   (Paste everything BELOW the opening "<?php" line.)
 *
 * Why: Yoast SEO free has no fields for the organisation's address/phone
 * or for the person's job title and ORCID. These filters add them to
 * Yoast's own schema graph, so there is one connected graph per page.
 * home_url() keeps the @ids correct after the switch to the real domain.
 *
 * Data source: client notes (memory.md §1f, confirmed by Nadja).
 */

// 1. Organisation (Yoast's node #organization): address, contact, founder.
add_filter( 'wpseo_schema_organization', function ( $data ) {
	$data['description'] = 'Nadja Gmelch’s systemic higher education consultancy for internationalisation, strategy, organisational development and leadership in Europe and beyond.';
	$data['email']       = 'nadja@u-teal.com';
	// German pages show the German number, all other pages the Spanish one (Nadja, 23 Nov 2026).
	$is_de               = function_exists( 'pll_current_language' ) && 'de' === pll_current_language();
	$data['telephone']   = $is_de ? '+49 151 72538515' : '+34 697 585 199';
	$data['contactPoint'] = array(
		array(
			'@type'             => 'ContactPoint',
			'contactType'       => 'customer support',
			'telephone'         => '+49 151 72538515',
			'email'             => 'nadja@u-teal.com',
			'availableLanguage' => array( 'de' ),
			'areaServed'        => array( 'DE', 'AT', 'CH' ),
		),
		array(
			'@type'             => 'ContactPoint',
			'contactType'       => 'customer support',
			'telephone'         => '+34 697 585 199',
			'email'             => 'nadja@u-teal.com',
			'availableLanguage' => array( 'en', 'es', 'it', 'ca' ),
		),
	);
	$data['address']     = array(
		'@type'           => 'PostalAddress',
		'streetAddress'   => 'Landsberger Straße 82',
		'postalCode'      => '82205',
		'addressLocality' => 'Gilching',
		'addressCountry'  => 'DE',
	);
	$data['founder'] = array( '@id' => home_url( '/#nadja-gmelch' ) );
	return $data;
} );

// 1b. German 404 page: browser-tab title in German (Yoast's 404 title setting is one text for all languages).
add_filter( 'wpseo_title', function ( $title ) {
	if ( is_404() && function_exists( 'pll_current_language' ) && 'de' === pll_current_language() ) {
		return 'Seite nicht gefunden - U-teal';
	}
	return $title;
} );

// 2. Person node for Nadja Gmelch, linked to the organisation.
add_filter( 'wpseo_schema_graph', function ( $graph ) {
	$graph[] = array(
		'@type'         => 'Person',
		'@id'           => home_url( '/#nadja-gmelch' ),
		'name'          => 'Nadja Gmelch',
		'jobTitle'      => 'Higher education consultant',
		'url'           => home_url( '/about-me/' ),
		'image'         => home_url( '/wp-content/uploads/2026/11/nadja-gmelch-portrait.jpg' ),
		'email'         => 'nadja@u-teal.com',
		'worksFor'      => array( '@id' => home_url( '/#organization' ) ),
		'knowsLanguage' => array( 'en', 'de', 'es', 'it', 'ca' ),
		'sameAs'        => array(
			'https://www.linkedin.com/in/nadja-gmelch/',
			'https://orcid.org/0000-0002-0721-1818',
		),
	);
	return $graph;
} );
