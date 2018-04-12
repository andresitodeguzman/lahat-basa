<?php
session_start();

require_once("_system/secrets.php");

if(empty($_POST['message'])) die("Message is required");

$message = $_POST['message'];
$number = $_SESSION['globe_subscriber_number'];
$number = "0$number";
$access_token = $_SESSION['globe_access_token'];

$stmt = http_build_query(array(
	"address" => "$number",
	"message" => "$message",
));

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/$sender_address/requests?access_token=$access_token");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $stmt);
$result = curl_exec($curl);
curl_close($curl);

echo $result;

?>