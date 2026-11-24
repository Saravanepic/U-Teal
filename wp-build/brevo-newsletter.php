<?php
/**
 * U-Teal · Footer newsletter → Brevo, double opt-in (PERMANENT snippet)
 * Paste into wp-admin › Snippets › Add New · type PHP · "Run snippet everywhere" · Activate.
 *
 * How it works
 * - The footer forms (Footer 193 EN / Footer – DE 291, element 3e73b9de) keep "collect-submissions"
 *   and get a second action "webhook" pointing at this site's own route:
 *     EN: https://u-teal.com/wp-json/uteal/v1/newsletter?lang=en&k=<UTEAL_NL_SECRET>
 *     DE: https://u-teal.com/wp-json/uteal/v1/newsletter?lang=de&k=<UTEAL_NL_SECRET>
 * - The route takes the email from the form data and asks Brevo to send its double opt-in mail
 *   (POST /v3/contacts/doubleOptinConfirmation). The contact only joins the list after clicking the link.
 * - The Brevo API key stays on the server and never reaches the browser.
 *
 * API key + secret: UTEAL_BREVO_API_KEY and UTEAL_NL_SECRET are defined at the top of the PASTED copy
 *   of this snippet only (never in this public repo). Fallback for the key: the Brevo plugin's stored key.
 *   The secret goes into k= of the two webhook URLs.
 * Brevo IDs (created 24 Nov 2026 via API): lists EN 3 / DE 4, DOI templates EN 5 / DE 6.
 */

function uteal_nl_api_key() {
	if ( defined( 'UTEAL_BREVO_API_KEY' ) && UTEAL_BREVO_API_KEY ) {
		return UTEAL_BREVO_API_KEY;
	}
	$v3 = get_option( 'sib_api_key_v3' ); // Brevo plugin's stored v3 key
	if ( is_string( $v3 ) && '' !== $v3 ) {
		return $v3;
	}
	$sib = get_option( 'sib_main_option' );
	return is_array( $sib ) && ! empty( $sib['access_key'] ) ? (string) $sib['access_key'] : '';
}

function uteal_nl_config( $lang ) {
	$config = array(
		'en' => array(
			'list_id'     => 3, // Brevo list "Newsletter EN"
			'template_id' => 5, // Brevo template "U-teal – Newsletter double opt-in (EN)"
			'redirect'    => 'https://u-teal.com/?newsletter=confirmed',
		),
		'de' => array(
			'list_id'     => 4, // Brevo list "Newsletter DE"
			'template_id' => 6, // Brevo template "U-teal – Newsletter Double-Opt-in (DE)"
			'redirect'    => 'https://u-teal.com/de/?newsletter=confirmed',
		),
	);
	return $config[ $lang ] ?? $config['en'];
}

/* Find the first valid email address anywhere in the posted form data (works whatever shape the webhook uses). */
function uteal_nl_find_email( $data ) {
	if ( is_string( $data ) ) {
		$candidate = sanitize_email( trim( $data ) );
		return is_email( $candidate ) ? $candidate : '';
	}
	if ( is_array( $data ) ) {
		foreach ( $data as $value ) {
			$found = uteal_nl_find_email( $value );
			if ( $found ) {
				return $found;
			}
		}
	}
	return '';
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'uteal/v1', '/newsletter', array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true', // checked with the shared secret below
		'callback'            => function ( WP_REST_Request $request ) {
			$api_key = uteal_nl_api_key();
			if ( ! $api_key || ! defined( 'UTEAL_NL_SECRET' ) ) {
				return new WP_Error( 'uteal_nl_config', 'Newsletter not configured.', array( 'status' => 500 ) );
			}
			if ( ! hash_equals( UTEAL_NL_SECRET, (string) $request->get_param( 'k' ) ) ) {
				return new WP_Error( 'uteal_nl_forbidden', 'Forbidden.', array( 'status' => 403 ) );
			}

			$lang   = 'de' === $request->get_param( 'lang' ) ? 'de' : 'en';
			$config = uteal_nl_config( $lang );
			$params = $request->get_params();
			unset( $params['k'], $params['lang'] );
			$email = uteal_nl_find_email( $params );
			if ( ! $email ) {
				return new WP_Error( 'uteal_nl_email', 'No valid email.', array( 'status' => 400 ) );
			}

			$response = wp_remote_post( 'https://api.brevo.com/v3/contacts/doubleOptinConfirmation', array(
				'timeout' => 15,
				'headers' => array(
					'api-key'      => $api_key,
					'accept'       => 'application/json',
					'content-type' => 'application/json',
				),
				'body'    => wp_json_encode( array(
					'email'          => $email,
					'includeListIds' => array( (int) $config['list_id'] ),
					'templateId'     => (int) $config['template_id'],
					'redirectionUrl' => $config['redirect'],
				) ),
			) );

			$code = is_wp_error( $response ) ? 0 : wp_remote_retrieve_response_code( $response );
			if ( $code < 200 || $code >= 300 ) {
				// Logged for debugging (wp-content/debug.log when WP_DEBUG_LOG is on); the address is not logged.
				error_log( 'U-teal newsletter: Brevo answered ' . $code . ' ' . ( is_wp_error( $response ) ? $response->get_error_message() : wp_remote_retrieve_body( $response ) ) );
				return new WP_Error( 'uteal_nl_brevo', 'Subscription failed.', array( 'status' => 502 ) );
			}
			return array( 'ok' => true );
		},
	) );
} );
