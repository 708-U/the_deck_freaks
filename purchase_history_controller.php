<?php
//
require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/purchase_history_model.php';

$css = './css/cart.css';

$sort_kind = 'DESC';

if(check_session()){
    $dbh = get_db_connect();

    $order_items = sql_get_order_history($dbh,$sort_kind);

    $date = sql_get_history_date($dbh);
} else {
    redirect_login();
}

include_once './view/header_view.php';
include_once './view/purchase_history_view.php';
include_once './view/footer_view.php';
