<?php
/**
 * All Wet
 * 2018
 * 
 * Callback
 */

// Start session
session_start();

// Include Keys
require_once("../_system/keys.php");

// Include DB
require_once("../_system/db.php");

// Include Required Class
require_once("../class/AllWet/Customer.class.php");


$code = "";

if(empty($_REQUEST['code'])) die("An Error Occured During Login");

if(!empty($_REQUEST['code'])) $code = $_REQUEST['code'];

$stmt = http_build_query(array(
    "app_id" => $glb_app_id,
    "app_secret" => $glb_app_secret,
    "code" => $code
));

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://developer.globelabs.com.ph/oauth/access_token");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $stmt);
$result = curl_exec($curl);
curl_close($curl);

$result = json_decode($result,true);

if(empty($result)) die("An Error Occured During Login");
if(!empty($result)){

    $access_token = $result['access_token'];
    $subscriber_number = $result['subscriber_number'];

    $customer = new AllWet\Customer($mysqli);
    
    $customer_info = $customer->getByCustomerNumber($subscriber_number);

    $customer_id = 0;

    if(empty($customer_info)){
        $c_array = array(
            "customer_number"=>$subscriber_number,
            "customer_name"=> "",
            "customer_longitude"=>"",
            "customer_latitude"=>"",
            "customer_address"=>"",
            "customer_image"=>"",
            "customer_access_token"=>$access_token
        );
        $customer->add($c_array);

        $customer_info = $customer->getByCustomerNumber($subscriber_number);
        $customer_id = $customer_info['customer_id'];

    } else {
        $customer_id = $customer_info['customer_id'];

        if($access_token != $customer_info['customer_access_token']){
            $customer->updateAccessToken($customer_id, $access_token);
        }
    }

    $_SESSION['customer_id'] = $customer_id;
    $_SESSION['logged_in'] =  True;
    $_SESSION['customer_number'] = $subscriber_number;

}

?>
<!Doctype html>
<html>
    <head>
        <script type="text/javascript">
            localStorage.setItem("all-wet-login",true);
            localStorage.setItem("all-wet-customer-id","<?=$customer_id?>");
            localStorage.setItem("all-wet-customer-number", "<?=$subscriber_number?>");

            window.location.replace('/authenticate/redirectToApp.php');
        </script>
    </head>
    <body>
        Please Wait...
    </body>
</html>