<?php 

	include("includes/Connect_client.php");
	function login(){
		session_start();
		//$client = $this->oauth_client->get_client();
		$obj = new Oauth_client();
		$client = $obj->get_client();
		$exparams = array(
			'state' => rand(10000, 99999)
		);
		//print_r(AUTHORIZATION_ENDPOINT);die;
		$auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI, $exparams);
		$_SESSION[CSC_CURR_URL]= $_SERVER['REQUEST_URI'];
		header('Location: ' . $auth_url);
		die('Redirect');	
}

login();
