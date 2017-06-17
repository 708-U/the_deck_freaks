<?php

require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/functions.php';
require_once './model/userinfo_model.php';

$css = './css/userinfo.css';

try{
    $dbh = get_db_connect();

    if(check_session()){

        $cart_status = sql_get_order_data($dbh,$_SESSION['user_id']);

        $total_amount = calc_total_amount($cart_status);

        $user_info = sql_get_user_data($dbh);
    }

} catch(PDOException $e) {
    echo '接続できませんでした。理由：'.$e->getMessage();
}
include_once './view/header_view.php';
include_once './view/userinfo_view.php';
include_once './view/footer_view.php';
