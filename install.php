<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "2d12e78ea02815d1cf11a17ab8bb74e4";
$scopes = "read_orders,write_products";
$redirect_uri = "https://agiledevelopers.in/shopify/app/generate_token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();