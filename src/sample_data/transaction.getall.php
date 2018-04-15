<?php
header("Content-type: application/json");

$array = array(
    array(
        "transaction_id" => "1",
        "transaction_date" => "Jan 5, 2018",
        "transaction_time" => "8:18 AM",
        "customer_id" => "1",
        "transaction_count" => "2",
        "transaction_price" => "300.00",
        "transaction_payment_method" => "Credit Card",
        "transaction_status" => "Delivered",
        "transaction_longitude" => "120.962915",
        "transaction_latitude" => "14.320946",
        "transaction_address" => "3rd Floor, Paulo Campos Hall"
    )
);
 
echo(json_encode($array));
?>