<?php

function sql_insert_order_history($dbh,$param) {
    $sql = 'INSERT INTO shop_history
                (user_id , item_id , price , amount ,created_at ,date_on_display)
            VALUES
                (:user_id , :item_id ,:price ,:amount ,:date, :date_on_display)';
    return insert_order_history($dbh, $sql, $param);
}

function insert_order_history($dbh, $sql, $param) {
    $date_on_display = date('Y/m/d H:i');
    $date = get_date();
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(user_id,$param['user_id'],PDO::PARAM_INT);
    $stmt->bindValue(item_id,$param['item_id'],PDO::PARAM_INT);
    $stmt->bindValue(price,$param['price'],PDO::PARAM_INT);
    $stmt->bindValue(amount,$param['amount'],PDO::PARAM_INT);
    $stmt->bindValue(date,$date,PDO::PARAM_STR);
    $stmt->bindValue(date_on_display,$date_on_display,PDO::PARAM_STR);
    $stmt->execute();
}

function sql_clear_cart($dbh,$param) {
    $sql = 'DELETE FROM
                shop_cart
            WHERE
                user_id = :user_id';
    return clear_cart($dbh, $sql, $param);
}

function clear_cart($dbh, $sql, $param) {
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(user_id,$param[0]['user_id'],PDO::PARAM_INT);
    $stmt->execute();
}

function sql_decrease_stock($dbh,$param) {
    $sql = 'UPDATE
                shop_stocks
            SET
                stock = :amount ,updated_at = :date
            WHERE
                id = :item_id';
    return decrease_stock($dbh, $sql, $param);
}

function decrease_stock($dbh, $sql, $param) {
    $amount = $param['stock'] - $param['amount'];
    $date = get_date();

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(amount,$amount,PDO::PARAM_INT);
    
    $stmt->bindValue(date,$date,PDO::PARAM_STR);
    
    $stmt->bindValue(item_id,$param['item_id'],PDO::PARAM_INT);
    
    $stmt->execute();
}

function sql_insert_point($dbh,$param) {
    $sql = 'UPDATE
                shop_users
            SET
                point = :point
            WHERE
                id = :id';
    return insert_point($dbh, $sql, $param);
}

function insert_point($dbh, $sql, $param) {
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(point,$param,PDO::PARAM_INT);
    $stmt->bindValue(id,$_SESSION['user_id'],PDO::PARAM_INT);
    $stmt->execute();
}
