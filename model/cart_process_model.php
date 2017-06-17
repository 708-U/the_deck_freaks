<?php

function validate_change($id ,$stock, $quantity){
    if(!validate_id($id)){
        return false;
    }
    if(!validate_stock($stock)){
        return false;
    }
    if(!validate_quantity($quantity)){
        return false;
    }
    return true;
}

function validate_id($param){
    if($param === ''){
        return set_flush_err_msg('入力値エラー');
    }
    else if(!is_numeric($param)){
        return set_flush_err_msg('入力値エラー');
    }
    return true;
}

function validate_stock($param){
    if($param === ''){
        return set_flush_err_msg('入力値エラー');
    }
    else if(!is_numeric($param)){
        return set_flush_err_msg('不正な入力値');
    }
    return true;
}

// 数量が空だった場合も商品削除処理をするため、trueを返す
// 例: if( 変更数量 === ''){
//       return true
//     }
// --> 削除処理実行
function validate_quantity($param){

    if($param === ''){
        return true;
    }
    else if(!is_numeric($param)){
        return set_flush_err_msg('数量は半角英数字を入力して下さい。');
    }
    else if(mb_strlen($param >= 100)) {
        return set_flush_err_msg('数量は99個以内にして下さい');
    }
    return true;
}

function check_stock($stock ,$order_stock){
    if($stock - $order_stock >= 0) {
        return true;
    }
    else{
        return set_flush_err_msg('入力数が在庫数より多いです。');
    }
}

function sql_update_cart_amount($dbh, $id, $param) {
    $sql = 'UPDATE
                shop_cart
            SET
                amount = :amount , updated_at = :date
            WHERE
                id = :id';
    return update_cart_amount($dbh, $sql ,$id ,$param);
}

function update_cart_amount($dbh, $sql, $id ,$param) {
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

// !!db削除関数
//
function sql_delete_cart($dbh,$param) {
    $sql = 'DELETE FROM
                shop_cart
            WHERE
                id =:id';
    return delete_cart($dbh,$sql,$param);
}

function delete_cart($dbh,$sql,$param){
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(id,$param, PDO::PARAM_INT);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    };
}
