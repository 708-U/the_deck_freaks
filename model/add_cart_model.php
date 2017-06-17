<?php

function redirect_product_detail($param){
    header('location:./product_detail_controller.php?detail=' . $param);
    exit;
}

function validate_quantity($param){
    if($param === '') {
        return set_flush_err_msg('購入数が入力されていません');
    }
    else if(!is_numeric($param)){
        return set_flush_err_msg('購入数は数字かつ半角英数字を入力して下さい');
    }
    else if(mb_strlen($param >= 100)) {
        return set_flush_err_msg('購入数は99個以内にして下さい');
    }
    return true;
}

function move_to_cart($dbh ,$id ,$quantity){

    // dbから現在の商品情報と在庫を取得
    global $product_data;
    $product_data = sql_get_purchase_data($dbh,$id);

    $order = ['user_id' => $_SESSION['user_id'],
              'item_id' => $id,
              'amount'  => $quantity];

    // 注文数が在庫より多いかどうかチェック
    $calc_amount = $product_data[0]['stock'] - $quantity;
    if($calc_amount >= 0) {
        // 注文数に応じて処理を変更
        $now_cart_info = sql_check_cart_exist($dbh,$id);
        if($actual_cart_info['amount'] > 0){
            $new_quantity = $now_cart_info['amount'] + $order['amount'];
            sql_update_cart($dbh, $id, $new_quantity);
            return true;
        }
        else{
            sql_insert_cart($dbh,$order);
            return true;
        }
    }
    else{
        return set_flush_err_msg('在庫数が入力数より少ないです。入力数を減らして下さい。');
    }
}

function sql_get_purchase_data($dbh,$param) {
    $sql = 'SELECT
                shop_items.id,
                shop_items.name,
                shop_items.price,
                shop_items.img,
                shop_items.color,
                shop_items.status,
                shop_stocks.stock
            FROM
                shop_items
            INNER JOIN
                shop_stocks
            ON
                shop_items.id = shop_stocks.id
            WHERE
                shop_stocks.id = :id';
    return get_purchase_data($dbh,$sql,$param);
}

function get_purchase_data($dbh,$sql,$param) {
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(id,$param,PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $product_list[] = $row;
        }
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $product_list;
}

function sql_check_cart_exist($dbh ,$param) {
    $sql = 'SELECT
                id ,amount
            FROM
                shop_cart
            WHERE
                item_id = :item_id';
    return check_cart_exist($dbh,$sql,$param);
}

function check_cart_exist($dbh,$sql,$param) {
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(item_id, $param, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetch();
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $count;
}

function sql_insert_cart($dbh,$param){
    $sql ='INSERT INTO shop_cart
                (user_id, item_id, amount ,created_at)
            VALUES
                (:user_id, :item_id, :amount, :date)';
    return insert_cart($dbh,$sql,$param);
}

function insert_cart($dbh,$sql,$param) {
    try{
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(user_id,$param['user_id'], PDO::PARAM_STR);
        $stmt->bindValue(item_id,$param['item_id'], PDO::PARAM_STR);
        $stmt->bindValue(amount,$param['amount'], PDO::PARAM_STR);

        $date = get_date();
        $stmt->bindValue(date,$date, PDO::PARAM_STR);
        $stmt->execute();
        } catch (PDOException $e) {
          throw $e;
    }
}

function sql_update_cart($dbh, $id, $param) {
    $sql = 'UPDATE
                shop_cart
            SET
                amount = :amount , updated_at = :date
            WHERE
                item_id = :id';
    return update_cart($dbh, $sql ,$id ,$param);
}

function update_cart($dbh, $sql, $id ,$param) {
    try{
        $date = get_date();
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(amount,$param, PDO::PARAM_INT);
        $stmt->bindValue(date,$date, PDO::PARAM_INT);
        $stmt->bindValue(id,$id, PDO::PARAM_INT);
        $stmt->execute();
        } catch (PDOException $e) {
          throw $e;
        };
        return TRUE;
}
