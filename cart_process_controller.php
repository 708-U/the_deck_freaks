<?php
require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/cart_process_model.php';

if (request_method('POST') && check_session()) {
    $cart_id  = trimming(get_post_data('cart_id'));
    $stock    = trimming(get_post_data('stock'));
    $quantity = trimming(get_post_data('quantity'));

    validate_change($cart_id, $stock, $quantity);

// 入力値に応じて処理変更
//
    if ($quantity > 0){
        $sql_kind = 'update_cart';
        check_stock($stock ,$quantity);
    }
    else if($quantity > 0 || $quantity === '') {
        $sql_kind = 'delete_cart';
    }
}

if(check_flush_err() === false){
    redirect_cart();
}

try{

    $dbh = get_db_connect();

    if ($sql_kind === 'update_cart'){
        sql_update_cart_amount($dbh, $cart_id,$quantity);
        set_flush_msg('カートを更新しました。');
    }
    else if ($sql_kind === 'delete_cart'){
        sql_delete_cart($dbh, $cart_id);
        set_flush_msg('カートから商品を削除しました。');
    }

} catch (PDOException $e) {
    throw $e;
}

redirect_cart();
