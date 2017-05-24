<?php 

	// Load the settings from the central config file
	require_once 'config.php';


	// Load library
	require_once 'lib/rest.php';
	require_once 'lib/oauth2_client.php';


	if ($_GET['p']=='callback') {

		// get callback code
		$code = $_GET['code'];
		$provider_token_uri = $sso_host.'user/access_token';
		$rst = $oauth->get_access_token( $provider_token_uri, $code, 'GET', array('access_token' => 'true') );

        $response = $rest->send_request($rst['url'], 'GET', $rst['args']);

		$result = (array) json_decode($response);
		echo "<pre>";
		var_dump($rst);
		echo "</pre>";
		die();

	} else {

	// Example simple
	$oauth->client_id = $client_id;
	$oauth->client_secret = $client_secret;
	$oauth->redirect_uri = $redirect_uri;
	$oauth->user_authentication( $sso_host.$sso_context, $more_args );

	}