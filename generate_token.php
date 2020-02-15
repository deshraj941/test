<?php

// Get our helper functions
require_once("inc/functions.php");
global $conn;


// Set variables for our request
$api_key = "2d12e78ea02815d1cf11a17ab8bb74e4";
$shared_secret = "07575a67312beefc968e8916f946901c";
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter


$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {

	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);

	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);

	// Store the access token
	$result = json_decode($result, true);
	
	$access_token = $result['access_token'];
	
	file_put_contents('token.txt', print_r($access_token, true));
	
	

	// $token = "41c5e95d070ae469e3dfbac2132a7eba";
	// $shop = "test-ajay-123";

	$query = array(
	  "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
	);

	// Run API call to get products
	$shop_name = explode(".",$params['shop']);
	$products = shopify_call($access_token, $shop_name[0], "/admin/products.json", array(), 'GET');
	
	
	
	file_put_contents("product-json.txt", print_r($products['response'], true));

	$productss = json_decode($products['response'], TRUE);
	
	
	foreach($productss['products'] as $product){
	   
	    foreach($product['variants'] as $variants){
	        
	     $var_sql = "INSERT INTO `variants`(`id`, `product_id`, `title`, `price`, `sku`, `image_id`, `inventory_item_id`) VALUES ('".$variants['id']."','".$variants['product_id']."','".$variants['title']."','".$variants['price']."','".$variants['sku']."','".$variants['image_id']."','".$variants['inventory_item_id']."')";
	      $conn->query($var_sql);   
	          
	         
	    }

	   $prod_sql = "INSERT INTO `products`(`product_id`, `title`, `description`, `vendor`, `product_type`, `created_at`, `updated_at`, `published_scope`, `tags`) VALUES ('".$product['id']."','".$product['title']."','".$product['body_html']."','".$product['vendor']."','".$product['product_type']."','".$product['created_at']."','".$product['updated_at']."','".$product['published_scope']."','".$product['tags']."')";
	     $conn->query($prod_sql);

	}


	// Show the access token (don't do this in production!)
	$ins_url = "https://" . $params['shop'] . "/admin";
	header("Location: " . $ins_url);

}else{
	// Someone is trying to be shady!
	die('This request is NOT from Shopify!');
}