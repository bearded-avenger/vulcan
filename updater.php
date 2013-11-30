<?php

class vulcanUpdater {

	function __construct() {

		add_action( 'init', array( $this, 'init' ) );

		define( 'BA_VULCAN_STORE_URL', 'http://nickhaskins.co' );
		define( 'BA_VULCAN_THEME_NAME', 'vulcan' );
	}

	function init(){


		$license = trim( get_option( 'ba_vulcan_license_key' ) );

		// Updater
		$edd_updater = new EDD_SL_Theme_Updater( array(
				'remote_api_url' 	=> BA_VULCAN_STORE_URL,
				'version' 			=> '1.0',
				'license' 			=> $license,
				'item_name' 		=> BA_VULCAN_THEME_NAME,
				'author'			=> 'Nick Haskins'
			)
		);

		// Updater Filters
		add_action('admin_menu', array($this,'license_menu'));
		add_action('admin_init', array($this,'register_option'));
		add_action('admin_init', array($this,'activate_license'));
		add_action('admin_init', array($this,'deactivate_license'));


	}

	function license_menu() {
		add_theme_page( 'Vulcan License', 'Vulcan License', 'manage_options', 'horizon-license', array($this,'license_page' ));
	}

	function license_page() {
		$license 	= get_option( 'ba_vulcan_license_key' );
		$status 	= get_option( 'ba_vulcan_license_key_status' );
		?>
		<div class="wrap">
			<h2><?php _e('Vulcan License','horizon'); ?></h2>
			<form method="post" action="options.php">

				<?php settings_fields('ba_vulcan_theme_license'); ?>

				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('License Key'); ?>
							</th>
							<td>
								<input id="ba_vulcan_license_key" name="ba_vulcan_license_key" type="text" class="regular-text" value="<?php esc_attr( $license ); ?>" />
								<label class="description" for="ba_vulcan_license_key"><?php _e('Enter your license key','horizon'); ?></label>
							</td>
						</tr>
						<?php if( false !== $license ) { ?>
							<tr valign="top">
								<th scope="row" valign="top">
									<?php _e('Activate License'); ?>
								</th>
								<td>
									<?php if( $status !== false && $status == 'valid' ) { ?>
										<span style="color:green;"><?php _e('active'); ?></span>
										<?php wp_nonce_field( 'ba_vulcan_nonce', 'ba_vulcan_nonce' ); ?>
										<input type="submit" class="button-secondary" name="ba_vulcan_license_deactivate" value="<?php _e('Deactivate License','horizon'); ?>"/>
									<?php } else {
										wp_nonce_field( 'ba_vulcan_nonce', 'ba_vulcan_nonce' ); ?>
										<input type="submit" class="button-secondary" name="ba_vulcan_license_activate" value="<?php _e('Activate License','horizon'); ?>"/>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php submit_button(); ?>

			</form>
		<?php
	}

	function register_option() {
		// creates our settings in the options table
		register_setting('ba_vulcan_theme_license', 'ba_vulcan_license_key', array($this,'sanitize_license' ));
	}

	function sanitize_license( $new ) {
		$old = get_option( 'ba_vulcan_license_key' );
		if( $old && $old != $new ) {
			delete_option( 'ba_vulcan_license_key_status' ); // new license has been entered, so must reactivate
		}
		return $new;
	}

	function activate_license() {

		if( isset( $_POST['ba_vulcan_license_activate'] ) ) {
		 	if( ! check_admin_referer( 'ba_vulcan_nonce', 'ba_vulcan_nonce' ) )
				return; // get out if we didn't click the Activate button

			global $wp_version;

			$license = trim( get_option( 'ba_vulcan_license_key' ) );

			$api_params = array(
				'edd_action' => 'activate_license',
				'license' => $license,
				'item_name' => urlencode( BA_VULCAN_THEME_NAME )
			);

			$response = wp_remote_get( add_query_arg( $api_params, BA_VULCAN_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

			if ( is_wp_error( $response ) )
				return false;

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "active" or "inactive"

			update_option( 'ba_vulcan_license_key_status', $license_data->license );

		}
	}

	function deactivate_license() {

		// listen for our activate button to be clicked
		if( isset( $_POST['ba_vulcan_license_deactivate'] ) ) {

			// run a quick security check
		 	if( ! check_admin_referer( 'ba_vulcan_nonce', 'ba_vulcan_nonce' ) )
				return; // get out if we didn't click the Activate button

			// retrieve the license from the database
			$license = trim( get_option( 'ba_vulcan_license_key' ) );


			// data to send in our API request
			$api_params = array(
				'edd_action'=> 'deactivate_license',
				'license' 	=> $license,
				'item_name' => urlencode( BA_VULCAN_THEME_NAME ) // the name of our product in EDD
			);

			// Call the custom API.
			$response = wp_remote_get( add_query_arg( $api_params, BA_VULCAN_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) )
				return false;

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed"
			if( $license_data->license == 'deactivated' )
				delete_option( 'ba_vulcan_license_key_status' );

		}
	}

	function check_license() {

		global $wp_version;

		$license = trim( get_option( 'ba_vulcan_license_key' ) );

		$api_params = array(
			'edd_action' => 'check_license',
			'license' => $license,
			'item_name' => urlencode( BA_VULCAN_THEME_NAME )
		);

		$response = wp_remote_get( add_query_arg( $api_params, BA_VULCAN_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if( $license_data->license == 'valid' ) {
			echo 'valid'; exit;
			// this license is still valid
		} else {
			echo 'invalid'; exit;
			// this license is no longer valid
		}
	}

}
new vulcanUpdater;