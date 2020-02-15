<?php

require_once("inc/functions.php");

global $conn;

$token = file_get_contents("token.txt","r");


// Run API call to get products
$shop = explode(".",$_GET['shop']);
$products = shopify_call($token, $shop[0], "/admin/products.json", array(), 'GET');


$products = json_decode($products['response'], TRUE);



    foreach($products['products'] as $product){

        $check = "SELECT `product_id` FROM `products` WHERE `product_id`='".$product['id']."'";
        $result = $conn->query($check);
        

        if (mysqli_num_rows($result) > 0) {

          foreach($product['variants'] as $variants){

            $check_var = "SELECT `id` FROM `variants` WHERE `id`='".$variants['id']."'";
            $result_var = $conn->query($check_var);

            if (mysqli_num_rows($result_var) > 0) {
              $up_var = "UPDATE `variants` SET `product_id`='".$variants['product_id']."',`title`='".$variants['title']."',`price`='".$variants['price']."',`sku`='".$variants['sku']."',`image_id`='".$variants['image_id']."',`inventory_item_id`='".$variants['inventory_item_id']."' WHERE `id`= '".$variants['id']."'";

              $conn->query($up_var);
              echo "2<br>";

            }else{

              $ins_var_sql = "INSERT INTO `variants`(`id`, `product_id`, `title`, `price`, `sku`, `image_id`, `inventory_item_id`) VALUES ('".$variants['id']."','".$variants['product_id']."','".$variants['title']."','".$variants['price']."','".$variants['sku']."','".$variants['image_id']."','".$variants['inventory_item_id']."')";

              $conn->query($ins_var_sql); 
              echo "3<br>";

            }
            
            
                   
          }
          $up_pro = "UPDATE `products` SET `title`='".$product['title']."',`description`='".$product['body_html']."',`vendor`='".$product['vendor']."',`product_type`='".$product['product_type']."',`created_at`='".$product['created_at']."',`updated_at`='".$product['updated_at']."',`published_scope`='".$product['published_scope']."',`tags`='".$product['tags']."' WHERE `product_id`='".$product['id']."'";
          $conn->query($up_pro);
          echo "1<br>";

        

       }else{

        foreach($product['variants'] as $variants){

          $ins_var_sql = "INSERT INTO `variants`(`id`, `product_id`, `title`, `price`, `sku`, `image_id`, `inventory_item_id`) VALUES ('".$variants['id']."','".$variants['product_id']."','".$variants['title']."','".$variants['price']."','".$variants['sku']."','".$variants['image_id']."','".$variants['inventory_item_id']."')";

          $conn->query($ins_var_sql); 
         echo "4<br>";

        }

        $ins_pro_sql = "INSERT INTO `products`(`product_id`, `title`, `description`, `vendor`, `product_type`, `created_at`, `updated_at`, `published_scope`, `tags`) VALUES ('".$product['id']."','".$product['title']."','".$product['body_html']."','".$product['vendor']."','".$product['product_type']."','".$product['created_at']."','".$product['updated_at']."','".$product['published_scope']."','".$product['tags']."')";
        $conn->query($ins_pro_sql);
        echo "5<br>";


       }
        
           
    }




?>