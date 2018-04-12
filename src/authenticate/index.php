<?php
/**
 * All Wet
 * 2018
 * 
 * Authenticate
 * index.php
 */

// Start session
session_start();

// Include Keys
require_once("../_system/keys.php");

// Check if logged in
if(@$_SESSION['logged_in']){

    // Initially set type as customer
    $at = "customer";

    // Check if Account type exist
    if(@$_SESSION['account_type']) $at = $_SESSION['account_type'];

    // Switch along account type and redirect accordingly
    switch($at){
        case("admin"):
            header("Location: ../admin");
            break;
        case("employee"):
            header("Location: ../employee");
            break;
        case("customer"):
            header("Location: ../app");
            break;
        default:
            header("Location: ../app");
            break;
    }
    
} else {

    // Auto redirect if account type doesn't exist
    if(@empty($_REQUEST['account_type'])){
        // Redirect to Globe
        header("Location: $glb_login_redirect");
    } else {

        // Switch along account type and redirect accordingly
        switch($_REQUEST['account_type']){
            case("admin"):
                header("Location: admin.php");
                break;
            case("employee"):
                header("Location: employee.php");
                break;
            case("customer"):
                header("Location: $glb_login_redirect");
                break;
            default:
                header("Location: $glb_login_redirect");
                break;
        }
    }
}
?>