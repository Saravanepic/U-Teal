<?php
/**
 * U-Teal · Case studies (PERMANENT snippet)
 * Paste into wp-admin › Snippets › Add New · type PHP · "Run snippet everywhere" · Activate.
 * Needs ACF (free) active.
 *
 * - Post type  case_study  → /case-studies/<slug>/  (no archive: /case-studies/ is a normal page)
 * - Taxonomy   case_group  → "Higher education" / "Other sectors" (overview sections, no public URLs)
 * - ACF fields (defined in code, shown on the case edit screen):
 *     cs_intro            detail intro (the tile text is the Excerpt)
 *     cs_approach_heading "My approach" / "Our approach"
 *     cs_quote, cs_quote_name, cs_quote_role   (optional; hidden when empty)
 *     cs_service_link     relative link of the service page, e.g. /internationalisation/
 * - Shortcodes used by the Elementor single template:
 *     [ut_case_back]   "All case studies" link → /case-studies/#<slug>
 *     [ut_case_quote]  quote block (outputs nothing when the case has no quote)
 *     [ut_case_service] "Learn more about this service" button (nothing when empty)
 */

add_action( 'init', function () {
	register_post_type( 'case_study', array(
		'labels'        => array(
			'name'          => 'Case studies',
			'singular_name' => 'Case study',
			'add_new_item'  => 'Add new case study',
			'edit_item'     => 'Edit case study',
			'all_items'     => 'All case studies',
			'menu_name'     => 'Case studies',
		),
		'public'        => true,
		'has_archive'   => false,
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-portfolio',
		'menu_position' => 21,
		'hierarchical'  => false,
		'rewrite'       => array( 'slug' => 'case-studies', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions', 'custom-fields' ),
	) );

	register_taxonomy( 'case_group', 'case_study', array(
		'labels'             => array(
			'name'          => 'Case groups',
			'singular_name' => 'Case group',
		),
		'public'             => false, // internal grouping only: no URLs, not in Yoast / sitemap / llms.txt
		'show_ui'            => true,
		'publicly_queryable' => false,
		'show_in_nav_menus'  => false,
		'show_admin_column'  => true,
		'show_in_rest'       => true,
		'hierarchical'       => true,
		'rewrite'            => false,
	) );

	foreach ( array( 'higher-education' => 'Higher education', 'other-sectors' => 'Other sectors' ) as $slug => $name ) {
		if ( ! term_exists( $slug, 'case_group' ) ) {
			wp_insert_term( $name, 'case_group', array( 'slug' => $slug ) );
		}
	}

	// Flush permalinks once so /case-studies/<slug>/ works right away.
	if ( get_option( 'ut_case_study_rewrite' ) !== '1' ) {
		flush_rewrite_rules( false );
		update_option( 'ut_case_study_rewrite', '1' );
	}
} );

// Yoast writes the meta description; stop Hello Elementor adding a second one from the excerpt.
add_filter( 'hello_elementor_description_meta_tag', '__return_false' );

// Case groups have no public pages → keep them out of the Yoast sitemap.
add_filter( 'wpseo_sitemap_exclude_taxonomy', function ( $exclude, $taxonomy ) {
	return $taxonomy === 'case_group' ? true : $exclude;
}, 10, 2 );

// Admin list: sort by "Order" (page attributes) like the overview page.
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() && $q->is_main_query() && $q->get( 'post_type' ) === 'case_study' && ! $q->get( 'orderby' ) ) {
		$q->set( 'orderby', 'menu_order' );
		$q->set( 'order', 'ASC' );
	}
} );

// ACF fields (local = defined in code, not editable as a field group in the UI).
add_action( 'acf/include_fields', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	acf_add_local_field_group( array(
		'key'      => 'group_ut_case_study',
		'title'    => 'Case study details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'case_study' ) ) ),
		'position' => 'acf_after_title',
		'fields'   => array(
			array( 'key' => 'field_cs_intro', 'name' => 'cs_intro', 'label' => 'Intro (detail page, under the title)', 'type' => 'textarea', 'rows' => 5, 'new_lines' => '',
				'instructions' => 'The tile text on the overview page is the Excerpt (right sidebar).' ),
			array( 'key' => 'field_cs_approach_heading', 'name' => 'cs_approach_heading', 'label' => 'Approach heading', 'type' => 'text', 'default_value' => 'My approach' ),
			array( 'key' => 'field_cs_quote', 'name' => 'cs_quote', 'label' => 'Quote (optional)', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),
			array( 'key' => 'field_cs_quote_name', 'name' => 'cs_quote_name', 'label' => 'Quote: name', 'type' => 'text', 'wrapper' => array( 'width' => 40 ) ),
			array( 'key' => 'field_cs_quote_role', 'name' => 'cs_quote_role', 'label' => 'Quote: role, organisation, country', 'type' => 'text', 'wrapper' => array( 'width' => 60 ) ),
			array( 'key' => 'field_cs_service_link', 'name' => 'cs_service_link', 'label' => 'Service page link', 'type' => 'text', 'placeholder' => '/internationalisation/',
				'instructions' => 'Relative link of the service page for the "Learn more about this service" button, e.g. /strategy-consulting/. German cases: /de/… ' ),
		),
	) );
} );

// [ut_case_back]
add_shortcode( 'ut_case_back', function () {
	$post = get_post();
	$base = function_exists( 'pll_get_post' ) && ( $pid = get_page_by_path( 'case-studies' ) ) && ( $tr = pll_get_post( $pid->ID ) ) ? get_permalink( $tr ) : home_url( '/case-studies/' );
	$hash = $post ? '#' . $post->post_name : '';
	return '<a class="cs-back" href="' . esc_url( $base . $hash ) . '">' . esc_html__( 'All case studies', 'u-teal' ) . '</a>';
} );

// [ut_case_quote]
add_shortcode( 'ut_case_quote', function () {
	$id    = get_the_ID();
	$quote = trim( (string) get_post_meta( $id, 'cs_quote', true ) );
	if ( $quote === '' ) {
		return '';
	}
	$name = get_post_meta( $id, 'cs_quote_name', true );
	$role = get_post_meta( $id, 'cs_quote_role', true );
	return '<figure class="ut-cs-quote">'
		. '<span class="ut-cs-quote__mark" aria-hidden="true">“</span>'
		. '<blockquote class="ut-cs-quote__text">' . esc_html( $quote ) . '</blockquote>'
		. '<figcaption class="ut-cs-quote__author">'
		. ( $name ? '<span class="ut-cs-quote__name">' . esc_html( $name ) . '</span>' : '' )
		. ( $role ? '<span class="ut-cs-quote__role">' . esc_html( $role ) . '</span>' : '' )
		. '</figcaption></figure>';
} );

// [ut_case_service]
add_shortcode( 'ut_case_service', function () {
	$link = trim( (string) get_post_meta( get_the_ID(), 'cs_service_link', true ) );
	if ( $link === '' ) {
		return '';
	}
	$url = preg_match( '#^https?://#', $link ) ? $link : home_url( $link );
	return '<a class="ut-cs-service" href="' . esc_url( $url ) . '">' . esc_html__( 'Learn more about this service', 'u-teal' ) . '</a>';
} );
