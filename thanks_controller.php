<?php
require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/thanks_model.php';

$css = './css/thanks.css';

if(request_method('POST')) {
    $process_kind = get_post_data('process_kind');
}

if($process_kind !== 'purchase') {
    header('location:./cart_controller.php');
    exit;
}

if(check_session()) {
    try {
        $dbh = get_db_connect();

        $user_info       = sql_get_user_data($dbh);
        $order_data      = sql_get_order_data($dbh);

        $payment         = calc_payment($order_data);
        $give_point      = calc_give_point($payment);
        $calcleted_point = $user_info[0]['point'] + $give_point;

        // トランザクション
        // カート内商品個数分ループ
        // $dbh->beginTransaction();

        foreach($order_data as $key) {
            sql_insert_order_history($dbh ,$key);
            sql_decrease_stock($dbh, $key);
        }
            sql_insert_point($dbh ,$calcleted_point);
            sql_clear_cart($dbh, $order_data);
        // $dbh->commit();
        //
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
}

include_once './view/header_view.php';
include_once './view/thanks_view.php';
include_once './view/footer_view.php';
