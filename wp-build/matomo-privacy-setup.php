<?php
/**
 * U-teal · Matomo privacy settings (ONE-TIME snippet)
 *
 * Where: wp-admin › Snippets › Add New
 *   Title: "Matomo privacy settings (one-time)"
 *   Type: PHP · Run snippet everywhere · Activate
 *   (Paste everything BELOW the opening "<?php" line.)
 * Then open any wp-admin page once. A notice at the top says whether it worked.
 * After "done", deactivate and delete this snippet.
 *
 * Why: Chrome shows a false "dangerous site" warning on Matomo Admin on the
 * temporary domain. This applies the same settings through Matomo's own code,
 * so nobody has to open that page. Matches Nadja's privacy policy (section 4.3):
 *   - tracking without cookies (Matomo › Settings › Tracking › Disable cookies)
 *   - IP addresses shortened by 2 bytes
 *   - raw data deleted after 180 days (6 months)
 *   - "Do Not Track" respected
 */

add_action( 'admin_init', function () {
	if ( get_option( 'ut_matomo_privacy_done' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! class_exists( '\WpMatomo\Settings' ) || ! class_exists( '\WpMatomo\Bootstrap' ) ) {
		update_option( 'ut_matomo_privacy_result', 'Matomo plugin not active.' );
		return;
	}

	$steps = array();
	try {
		// 1. WordPress side: no tracking cookies (regenerates the tracking code).
		$settings = class_exists( '\WpMatomo' ) && \WpMatomo::$settings ? \WpMatomo::$settings : new \WpMatomo\Settings();
		$settings->apply_tracking_related_changes( array( 'disable_cookies' => true ) );
		$steps[] = 'cookies off';

		// 2. Matomo side: IP anonymisation, raw data deletion, Do Not Track.
		\WpMatomo\Bootstrap::do_bootstrap();
		\Piwik\Access::doAsSuperUser( function () use ( &$steps ) {
			$api = \Piwik\Plugins\PrivacyManager\API::getInstance();
			$api->setAnonymizeIpSettings( true, 2, false );
			$steps[] = 'IP 2 bytes';

			\Piwik\Plugins\PrivacyManager\PrivacyManager::savePurgeDataSettings( array(
				'delete_logs_enable'     => 1,
				'delete_logs_older_than' => 180,
			) );
			$steps[] = 'raw data 180 days';

			$api->activateDoNotTrack();
			$steps[] = 'Do Not Track';
		} );

		update_option( 'ut_matomo_privacy_done', 1 );
		update_option( 'ut_matomo_privacy_result', 'done: ' . implode( ', ', $steps ) );
	} catch ( \Throwable $e ) {
		update_option( 'ut_matomo_privacy_result', 'stopped after [' . implode( ', ', $steps ) . ']: ' . $e->getMessage() );
	}
} );

add_action( 'admin_notices', function () {
	$result = get_option( 'ut_matomo_privacy_result' );
	if ( ! $result || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$ok = 0 === strpos( $result, 'done' );
	printf(
		'<div class="notice notice-%1$s"><p><strong>Matomo privacy settings:</strong> %2$s</p></div>',
		$ok ? 'success' : 'error',
		esc_html( $result . ( $ok ? ' (you can delete this snippet now)' : '' ) )
	);
} );
