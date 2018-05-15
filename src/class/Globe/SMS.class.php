<?php
/*
All Wet
2018

Globe
SMS
*/

namespace Globe;

class SMS {

	private $app_id;
	private $app_secret;
	private $sender_address;

	private $access_token;

	private $number;
	private $message;

	function __construct(String $app_id,String $app_secret,String $sender_address){
		$this->app_id = $app_id;
		$this->app_secret = $app_secret;
		$this->sender_address = $sender_address;
	}

	final public function setAccessToken(String $access_token){
		$this->access_token = $access_token;
	}

	final public function sendSMS(String $number, String $message){
		$this->number = $number;
		$this->message = $message;

		$access_token = $this->access_token;

		$stmt = http_build_query(array(
			"address"=>$number,
			"message"=>$message
		));

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/$sender_address/requests?access_token=$access_token");

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $stmt);
		$result = curl_exec($curl);
		curl_close($curl);

		return $result;
	}

}
?>