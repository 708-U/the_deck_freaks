<?php
require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/index_model.php';

$css = './css/index.css';

if(check_session()) {
    try{
        $dbh = get_db_connect();

        $cart_status = sql_get_order_data($dbh);
        $total_amount = calc_total_amount($cart_status);

    } catch (PDOException $e) {
        echo '接続できませんでした。理由：'.$e->getMessage();
    }
}

include_once './view/header_view.php';
include_once './view/index_view.php';
include_once './view/footer_view.php';
