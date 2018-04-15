<?php
header("Content-type: application/json");

$array = array(
    array(
        "category_id" => "1",
        "category_name" => "Bottled Water",
        "category_description" => "For on-the-go",
        "category_code" => "BTLWTR"
    ),
    array(
        "category_id" => "2",
        "category_name" => "Container",
        "category_description" => "No water included",
        "category_code" => "CONTAIN"
    ),
    array(
        "category_id" => "3",
        "category_name" => "Water Dispenser Friendly",
        "category_description" => "For your amazing hot-cold maker",
        "category_code" => "WATDIS"
    )
);

echo(json_encode($array));
?>