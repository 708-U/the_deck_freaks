<?php
require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/cart_model.php';

$css = './css/cart.css';

$product_data = [];
$payment      = [];

if(check_session() === false){
    redirect_login();
}
// セッション後処理
try{
    $dbh = get_db_connect();

    $product_data = sql_get_order_data($dbh);

    $total_amount = calc_total_amount($product_data);
    if($total_amount < 1){
        redirect_cart_empty();
    }
    else {
        $user_info    = sql_get_user_data($dbh);
        $point        = $user_info[0]['point'];
    }

} catch (PDOException $e) {
    echo 'DBエラー：'.$e->getMessage();
}

$payment      = calc_payment($product_data);
$give_point   = calc_give_point($payment);

if(check_flush_err() === false){
    $err_msg = get_flush_err_msg();
}
else if(check_flush_msg() === false) {
    $success_msg = get_flush_msg();
}

include_once './view/header_view.php';
include_once './view/cart_view.php';
include_once './view/footer_view.php';
