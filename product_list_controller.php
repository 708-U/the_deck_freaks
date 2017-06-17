<?php

require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/product_list_model.php';

$css = './css/product_list.css';
$img_dir = './product_img/';
$product_data = [];


try {
    $dbh = get_db_connect();
    $on_sale_list = sql_get_product_data($dbh);
    
    if(check_session()){
        $cart_status = sql_get_order_data($dbh,$_SESSION['user_id']);
        $total_amount = calc_total_amount($cart_status);
        
    }
    
} catch (PDOException $e) {
    echo 'DBエラー：'.$e->getMessage();
}

include_once './view/header_view.php';
include_once './view/product_list_view.php';
include_once './view/footer_view.php';
