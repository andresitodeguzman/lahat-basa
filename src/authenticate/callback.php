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


if(!empty($_POST['unsubscribed'])){
    $unsubscribed = $_POST['unsubscribed'];
    $subscriber_number = $unsubscribed['subscriber_number'];

    $customer = new AllWet\Customer($mysqli);

    $customer_info = $customer->getByCustomerNumber($subscriber_number);

    $customer_id = $customer_info['customer_id'];

    $customer->delete($customer_id);

    die(json_encode(array("code"=>"200","message"=>"Customer deleted")));    
} else {
    $code = "";

    if(empty($_REQUEST['code'])) die("An Error Occured During Login");

    if(!empty($_REQUEST['code'])) $code = $_REQUEST['code'];

    $stmt = http_build_query(array(
        "app_id" => "qqEaI8eXAzhMoi4xREcXMKhB5qa8I6nL",
        "app_secret" => "6504608c9d5cda4473066f7c33057e870a1c6834b59c300a5bf889a881e976a0",
        "code" => "jzC5947aIB4p5yfReqn8F69x7eUzna6yIMybLEHBEEXnubgeXdsAeEG8HzrpqKI6M7apunX9xyhXBL6ysBrBA5fr6BpbUekjb7C7rXBRHopknefeznyrF6pBaetq5idLe97iBnLtKGnkxFzpk6KfkKXnrHqLjR9CkBBj6UajBB4f5XLXrs4b98Bhpg7nju4apezIxbEEaHRqegBsjLE5Au8xbK6H5Ka9jIEMx9AUdaqRaFzjpGnfMa4AEIEppq8C"
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
            $ac = $result['access_token'];
            $cat = $customer_info['customer_access_token'];

            if(($ac != $cat) XOR empty($cat)){
                $customer->updateAccessToken($customer_id, $access_token);
            }
        }

        $_SESSION['account_type'] = "customer";
        $_SESSION['customer_id'] = $customer_id;
        $_SESSION['logged_in'] =  True;
        $_SESSION['customer_number'] = $subscriber_number;

    }
}

?>
<!Doctype html>
<html>
    <head>
        <script type="text/javascript">
            localStorage.setItem("all-wet-account-type","customer");
            localStorage.setItem("all-wet-login",true);
            localStorage.setItem("all-wet-customer-id","<?=$customer_id?>");
            localStorage.setItem("all-wet-customer-number", "<?=$subscriber_number?>");

            <?php
            if($customer_info){
                $customer_info = json_encode($customer_info);
                echo "
                    localStorage.setItem('all-wet-customer-info','$customer_info');
                ";
            } else {
                echo "
                    var setupUserInfo = ()=>{
                        var info = [];
                        localStorage.setItem('all-wet-customer-info',JSON.stringify(info));
                    };

                    setupUserInfo();
                ";
            }
            ?>

            window.location.replace('/authenticate/redirectToApp.php');
        </script>
    </head>
    <body>
        Please Wait...
    </body>
</html>