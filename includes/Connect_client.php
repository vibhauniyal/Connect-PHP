<?php 
require('includes/lib/OAuth2/Client.php');
require('includes/lib/OAuth2/GrantType/IGrantType.php');
require('includes/lib/OAuth2/GrantType/AuthorizationCode.php');

const CLIENT_ID     = '5d8a9e86-3702-4f4d-a727-f58d23eb33de';
const CLIENT_SECRET = 'testpass';
const CLIENT_TOKEN = '32zDIHeOPeVunekZ';

const REDIRECT_URI           = 'http://localhost/sandeep/merchant/Auth.php';
const AUTHORIZATION_ENDPOINT = 'http://localhost/sandeep/oauth2/index.php/account/authorize';
const TOKEN_ENDPOINT         = 'http://localhost/sandeep/oauth2/index.php/account/token';
const RESOURCE_URL           = 'http://localhost/sandeep/oauth2/index.php/account/resource';

class Oauth_client{
	private $_client;
	public function __construct(){
		$pass = Oauth_client::_encrypt(CLIENT_SECRET);
		$this->_client = new OAuth2\Client(CLIENT_ID, $pass);
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

//End of Oauth_client ..
