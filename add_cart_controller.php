<?php

require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/add_cart_model.php';

$css = './css/cart.css';
$cart_data = [];

// ポスト、ログインチェック
if(request_method('POST') === false) {
    redirect_cart();
}
else if(check_session() === false){
    redirect_login();
}
else{
    $product_id     = trimming(get_post_data('product_id'));
    $order_quantity = trimming(get_post_data('order_quantity'));

    validate_quantity($order_quantity);
}

// エラーチェック後商品をカートに追加処理
if(check_flush_err() === false){
    redirect_product_detail($product_id);
}
else {
    try{
        $dbh = get_db_connect();

        if(move_to_cart($dbh ,$product_id ,$order_quantity) !== true){
            redirect_product_detail($product_id);
        }

        $cart_status  = sql_get_order_data($dbh,$_SESSION['user_id']);
        $total_amount = calc_total_amount($cart_status);

    } catch (PDOException $e) {
        echo '接続できませんでした。理由：'.$e->getMessage();
    }
}

include_once './view/header_view.php';
include_once './view/add_cart_view.php';
include_once './view/footer_view.php';
