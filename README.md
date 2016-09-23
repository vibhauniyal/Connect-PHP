# Connect-PHP
CSC  Digital Seva Connect Integration Kit  for PHP

Instructions:
* Reset your password by using the link you have recieved via email.

* Supports PHP version 5.3 and above.

* Login to following Merchant Center Portal: "portal.csccloud.in" and follow the below steps:

      Generate Connect Config. File
      
        1.Click on “CSC Connect”.
        
        2.Provide the Application Name, Call Back Url and upload the application logo and click on save button to add the application.
        
        3.Generate your Client ID by clicking on "Generate Client Id" button.
        
        4.Generate your Client Secret and Client Token.
        
        5.Click on save button to generate your Connect Config. File.
        
        6.Download the Connect Config. File.
        
Use these configuration file into your code.

The illustrated code sample below provides the understanding of using the php integration kit.

Step 1	Create a URL as in the sample login.php

      <?php
      session_start(); 
      include("includes/Connect_client.php");
      function login()
      {
          $obj = new Connect_client();
          $client = $obj->get_client();
          $exparams = array(
              'state' => rand(10000, 99999)
          );
          $state_val = rand(10000, 99999);
          $_SESSION['state_val'] = $state_val;
          $exparams = array(
              'state' => $state_val
          );
          
          $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI, $exparams);
          $_SESSION[CSC_CURR_URL] = $_SERVER['REQUEST_URI'];
          header('Location: ' . $auth_url);
          die('Redirect');    
      }
      login();

Note: include/Connect_client.php
      
      <?php 
        require('includes/lib/Connect/Client.php');
        require('includes/lib/Connect/GrantType/IGrantType.php');
        require('includes/lib/Connect/GrantType/AuthorizationCode.php');
        
        const CLIENT_ID     = '5d8a9e86-3702-4f4d-a727-f58d23eb33de';
        const CLIENT_SECRET = 'testpass';
        const CLIENT_TOKEN = '32zDIHeOPeVunekZ';
        
        const REDIRECT_URI           = 'http://localhost/sandeep/merchant/Auth.php';
        const AUTHORIZATION_ENDPOINT = 'http://localhost/sandeep/connect/index.php/account/authorize';
        const TOKEN_ENDPOINT         = 'http://localhost/sandeep//connect/index.php/account/token';
        const RESOURCE_URL           = 'http://localhost/sandeep/connect/index.php/account/resource';
        class connect_client{
        	private $_client;
        	public function __construct(){
        		$pass = connect_client::_encrypt(CLIENT_SECRET);
        		$this->_client = new Connect\Client(CLIENT_ID, $pass);
        	}
        	public function get_client(){
        		return $this->_client;
        	}
        	private static function _encrypt($in_t){
        		$key = CLIENT_TOKEN;
        		$pre = ":";
        		$post = "@";
        		$plaintext = rand(10, 99) . $pre . $in_t . $post . rand(10,99);
        		$iv = "0000000000000000";
        		$pval = 16 - (strlen($plaintext) % 16);
        		$ptext = $plaintext . str_repeat(chr($pval), $pval);
        		$dec = @mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $ptext, MCRYPT_MODE_CBC, $iv );
        		return bin2hex($dec);
        	}
      }

Step 2	Handle response to get user data as in the sample login_success.php


    <?php
            include("includes/Connect_client.php");
      
        function callback()
        { 
            $obj = new Connect_client();
            $client = $obj->get_client();
            $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
            $response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);
            $res = $response['result'];
            $client->setAccessToken($res['access_token']);
            $response = $client->fetch(RESOURCE_URL);
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
            header("Location:login.php");
        }
        callback();
        

Step 3	Create a user session with data as mentioned in Step 2:  login_success.php

    session_start();
    		$_SESSION['username']=$username;
    		$_SESSION['user_id']=$user_id;
    		$_SESSION['email']=$email;
    		$_SESSION['aadhaar']=$aadhaar;
    		$_SESSION['user_type']=$user_type;                   
