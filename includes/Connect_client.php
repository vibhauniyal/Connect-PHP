<?php 
require('includes/lib/OAuth2/Client.php');
require('includes/lib/OAuth2/GrantType/IGrantType.php');
require('includes/lib/OAuth2/GrantType/AuthorizationCode.php');

const CLIENT_ID     = 'CLIENT ID';
const CLIENT_SECRET = 'CLIENT SECRET';
const CLIENT_TOKEN  = 'CLIENT TOKEN';

const REDIRECT_URI           = 'MERCHANT CALLBACK URL';   // Merchant Auth callback URL

const AUTHORIZATION_ENDPOINT = 'AUTHORIZE URI';    // CSC Connect authorization URL
const TOKEN_ENDPOINT         = 'TOKEN URI';  // CSC Connect Token endpoint
const RESOURCE_URL           = 'USER URI';  // // CSC Connect Useer Resource endpoint

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
