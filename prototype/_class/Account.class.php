<?php

class Account {

  public $code;

  public function isLoggedIn(){
    // Set values
    $ret = False;

    // Check if contains code
    if(!empty($_SESSION['globe_access_token'])) $ret = True;


    // Return result
    return $ret;
  }

  public function initSession($access_token, $subscriber_number){
    $_SESSION['globe_access_token'] = $access_token;
    $_SESSION['globe_subscriber_number'] = $subscriber_number;
    return True;
  }

  public function destroySession(){
    $_SESSION['globe_access_token'] = "";
    $_SESSION['globe_subscriber_number'] = "";
    session_destroy();
    return True;
  }

  public function getAccessTokenPhoneNumber($app_id = NULL,$app_secret = NULL,$code = NULL){
    // Input checking
    if(empty($code)) return array("code"=>"400","message"=>"Code Empty");
    if(!empty($code)) $this->code = $code;

    $stmt = http_build_query(array(
      "app_id" => $app_id,
      "app_secret" => $app_secret,
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

    return $result;

  }

}

?>