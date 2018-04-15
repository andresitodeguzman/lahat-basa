<?php
header("Content-type: application/json");

$array = array(
    array(
        "transitem_id" => "1",
        "transaction_id" => "1",
        "product_id" => "2",
        "product_name" => "Blue and Tough 1 Gallon",
        "transitem_quantity" => "4"
    ),
    array(
        "transitem_id" => "2",
        "transaction_id" => "1",
        "product_id" => "3",
        "product_name" => "5 Gallon Water Refill",
        "transitem_quantity" => "1"
    )
);

echo(json_encode($array));
?>