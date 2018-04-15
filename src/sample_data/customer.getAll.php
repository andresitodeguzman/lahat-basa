<?php
header("Content-type: application/json");

$array = array(
    array(
        "customer_id" => "1",
        "customer_number" => "912902229",
        "customer_name" => "Juan de la Cruz",
        "customer_longitude" => "",
        "customer_latitude" => "",
        "customer_address" => "",
        "customer_image" => "",
        "customer_access_token" => "qdQjNv1b6KnrQDq8WlWvnohCcP5nb6CuFLkzovmECdo"
    ),
    array(
        "customer_id" => "2",
        "customer_number" => "9563856453",
        "customer_name" => "",
        "customer_longitude" => "",
        "customer_latitude" => "",
        "customer_address" => "",
        "customer_image" => "",
        "customer_access_token" => "qdQjNv1b6KnrQDq8WlWvnohCcP5nb6CuFLkzovmECdo"
    )
);

echo(json_encode($array));
?>