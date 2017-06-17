<?php
require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/cart_model.php';

$css = './css/cart_empty.css';

$product_data = [];
$payment      = [];

if(check_session() === false){
    header('location:./login_controller.php');
    exit;
    
}
else {
    try{
        $dbh = get_db_connect();
    
        $product_data = sql_get_order_data($dbh);
        $total_amount = calc_total_amount($product_data);
        
        if($total_amount > 0) {
            header('location:./cart_controller.php');
            exit;
        }
    } 
    catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
}

include_once './view/header_view.php';
include_once './view/cart_empty_view.php';
include_once './view/footer_view.php';
