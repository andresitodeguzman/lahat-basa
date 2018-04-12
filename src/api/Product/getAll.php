<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Product
 * getAll
 */
require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$_SESSION['logged_in'] = True;

$obj = new AllWet\Product($mysqli);
$cat = new AllWet\Category($mysqli);

$data = $obj->getAll();

$f_arr = array();

foreach($data as $d){
    $product_id = $d['product_id'];
    $product_code = $d['product_code'];
    $product_name = $d['product_name'];
    $product_description = $d['product_description'];
    $category_id = $d['category_id'];
    $category_name = "";
    $product_price = $d['product_price'];
    $product_available = $d['product_available'];
    $product_image = $d['product_image'];
	
    if($category_id){
        $category_inf = $cat->get($category_id);
        $category_name = $category_inf['category_name'];
    }
	
    $arr = array(
        "product_id"=>"$product_id",
        "product_code"=>"$product_code",
        "product_name"=>"$product_name",
        "product_description"=>"$product_description",
        "category_id"=>"$category_id",
        "category_name"=>"$category_name",
        "product_price"=>"$product_price",
        "product_available"=>"$product_available",
        "product_image"=>"$product_image",
    );
	
    array_push($f_arr, $arr);
}

if(empty($f_arr)){
    $f_arr = json_encode(array());
} else {
    $f_arr = json_encode($f_arr);
}

echo $f_arr;

?>