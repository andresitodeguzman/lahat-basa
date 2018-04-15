<?php
header("Content-type: application/json");

$array = array(
    array(
        "product_id" => "1",
        "product_code" => "BTL-WILKO",
        "product_name" => "Wilkins Orange 25ml",
        "product_description" => "Yummy!",
        "category_id" => "1",
        "category_name" => "Bottled Water",
        "product_price" => "18.00",
        "product_available" => "True",
        "product_image" => "",
    ),
    array(
        "product_id" => "2",
        "product_code" => "CONT-BT1GL",
        "product_name" => "Blue and Tough 1 Gallon",
        "product_description" => "Great for travel",
        "category_id" => "2",
        "category_name" => "Container",
        "product_price" => "35.00",
        "product_available" => "False",
        "product_image" => "",
    ),
    array(
        "product_id" => "3",
        "product_code" => "WATDIS-5G",
        "product_name" => "5 Gallon Water Refill",
        "product_description" => "Container sold separately",
        "category_id" => "3",
        "category_name" => "Water Dispenser Friendly",
        "product_price" => "25.50",
        "product_available" => "True",
        "product_image" => "",
    )
);

echo(json_encode($array));
?>