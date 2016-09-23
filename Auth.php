<?php
		include("includes/Connect_client.php");
	
	function callback()
	{ 
		//$start1 = date('Y-m-d H:i:s', time());
		$start1 = microtime(true);
		//$client = $this->oauth_client->get_client();
		$obj = new Oauth_client();
		$client = $obj->get_client();

		$params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
		  
		//$start2 = date('Y-m-d H:i:s', time());
		$start2 = microtime(true);
		$response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);
		//$start3 = date('Y-m-d H:i:s', time());
		$start3 = microtime(true);
		  
		$res = $response['result'];
		  
		$client->setAccessToken($res['access_token']);
		//$start4 = date('Y-m-d H:i:s', time());
		$start4 = microtime(true);
		$response = $client->fetch(RESOURCE_URL);
		//$start5 = date('Y-m-d H:i:s', time());
		$start5 = microtime(true);
		 
		//echo "<pre>"; 
		//print_r($response['result']['User']);

		$username=$response['result']['User']['username'];
		$user_id=$response['result']['User']['user_id'];
		$email=$response['result']['User']['email'];
		$aadhaar=$response['result']['User']['aadhar_number'];
		$user_type=$response['result']['User']['user_type'];

		session_start();
		$_SESSION['username']=$username;
		$_SESSION['user_id']=$user_id;
		$_SESSION['email']=$email;
		$_SESSION['aadhaar']=$aadhaar;
		$_SESSION['user_type']=$user_type;
		//$start6 = date('Y-m-d H:i:s', time());
		$start6 = microtime(true);
		$log_srt = 
			"1> " . $start1 . "\n" . 
			"2> " . $start2 . "\n" . 
			"3> " . $start3 . "\n" . 
			"4> " . $start4 . "\n" . 
			"5> " . $start5 . "\n" . 
			"6> " . $start6 . "\n";
		file_put_contents(__DIR__ . '/log/abc.log', $log_srt, FILE_APPEND);
//		echo($log_srt);die;
		header("Location:login.php");

	}

	callback();
	
