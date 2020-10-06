<?php
/*
 * Template name: Custom Login
 */

$client_id = '593519547913382'; // Facebook APP Client ID
$client_secret = '8b8f14b35b33e7d08e84a4bc285e4472'; // Facebook APP Client secret
$redirect_uri = 'https://sandbox.local/'; // URL of page/file that processes a request

// in our case we ask facebook to redirect to the same page, because processing code is also here
// processing code
if ( isset( $_GET['code'] ) && $_GET['code'] ) {

	// first of all we should receive access token by the given code
	$params = array(
		'client_id'     => $client_id,
		'redirect_uri'  => $redirect_uri,
		'client_secret' => $client_secret,
		'code'          => $_GET['code']
	);

	// connect Facebook Grapth API using WordPress HTTP API
	$tokenresponse = wp_remote_get( 'https://graph.facebook.com/oauth/access_token?' . http_build_query( $params ) );

	$token = json_decode( wp_remote_retrieve_body( $tokenresponse ) );

	if ( isset( $token->access_token )) {

		// now using the access token we can receive informarion about user
		$params = array(
			'access_token'	=> $token->access_token,
			'fields'		=> 'id,name,email,link,first_name,last_name' // info to get
		);

		// connect Facebook Grapth API using WordPress HTTP API
		$useresponse = wp_remote_get('https://graph.facebook.com/v6.0/me' . '?' . urldecode( http_build_query( $params ) ) );

		$fb_user = json_decode( wp_remote_retrieve_body( $useresponse ) );

		// if ID and email exist, we can try to create new WordPress user or authorize if he is already registered
		if ( isset( $fb_user->id ) && isset( $fb_user->email ) ) {

			// if no user with this email, create him
			if( !email_exists( $fb_user->email ) ) {

				$userdata = array(
					'user_login'  =>  $fb_user->email,
					'user_pass'   =>  wp_generate_password(), // random password, you can also send a notification to new users, so they could set a password themselves
					'user_email' => $fb_user->email,
					'first_name' => $fb_user->first_name,
					'last_name' => $fb_user->last_name
				);
				$user_id = wp_insert_user( $userdata );

				update_user_meta( $user_id, 'facebook', $fb_user->link );

			} else {
				// user exists, so we need just get his ID
				$user = get_user_by( 'email', $fb_user->email );
				$user_id = $user->ID;
			}

			// authorize the user and redirect him to admin area
			if( $user_id ) {
				wp_set_auth_cookie( $user_id, true );
				wp_redirect( home_url() );
				exit;
			}

		}

	}
}

// Build Login URL
$params = array(
  'client_id'     => $client_id,
  'redirect_uri'  => $redirect_uri,
  'response_type' => 'code',
  'scope'         => 'email'
);
$login_url = 'https://www.facebook.com/dialog/oauth?' . urldecode( http_build_query( $params ) );
?>
<p><a href="<?php echo $login_url ?>">Login via Facebook</a></p>
