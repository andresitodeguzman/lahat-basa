<?php
/*
Inbound
Not yet functional
*/
require_once("_system/secrets.php");

if(empty($_REQUEST)) die("Data is required");

$list = $_REQUEST['inboundSMSMessageList']['inboundSMSMessage'];

foreach($list as $msg){
	$dateTime = $msg['dateTime'];
	$destinationAddress = $msg['destinationAddress'];
	$messageId = $msg['messageId'];
	$message = $msg['message'];
	$resourceUrl = $msg['resourceUrl'];
	$senderAddress = $msg['senderAddress'];

	$reply = "";

	if($message == "HELP" XOR "help"){
		$reply = "
		ALL WET!\n
		Get your water delivered instantly whenever, wherever.\n
		\n
		Text 'DELIVER <No. of Gallon>/<address>' and send it to this number.\n
		Gallons: 3 - P20, 30 - P30\n
		ex: DELIVER 30/The District, Imus \n\n
		SMS Charges Apply.
		";
	}

	if(stripos($message,"DELIVER ")){
		$message = str_replace("DELIVER ", "", $message);
		$posar = explode("/", $message);
		$amount = $posar[0];
		$address = $posar[1];
		$price = "";
		if($amount == '3') $price = "Please prepare payment of PHP 20.";
		if($amount == '30') $price = "Please prepare payment of PHP 30.";
		$reply = "
		ALL WET: Good day! Your order of $amount gallons will be delivered shortly at $address. $price Thank you! This message is FREE of charge.
		";
	}

	$number = "0$senderAddress";
	$access_token = "eb0CkvSSCnU0BndxRkiOrK_sM2kFByZ_1MQdcYcgoLg";
	$stmt = http_build_query(array(
		"address" => "$number",
		"message" => "$reply",
	));

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/$sender_address/requests?access_token=$access_token");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $stmt);
	$result = curl_exec($curl);
	curl_close($curl);



}

?>