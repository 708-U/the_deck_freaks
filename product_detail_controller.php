<?php
require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/product_detail_model.php';

$css = './css/product_detail.css';

$product_detail = [];
check_session();

if(request_method('GET')) {
    $detail = get_GET_data('detail');
}

try {
    $dbh = get_db_connect();
    $product_detail = sql_get_product_detail($dbh,$detail);

    $cart_status = sql_get_order_data($dbh,$_SESSION['user_id']);
    $total_amount = calc_total_amount($cart_status);

} catch (PDOException $e) {
echo '接続できませんでした。理由：'.$e->getMessage();
}

$err_msg = get_flush_err_msg();

include_once './view/header_view.php';
include_once './view/product_detail_view.php';
include_once './view/footer_view.php';
