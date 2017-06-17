<?php

function sql_get_history_date($dbh){
    $sql = 'SELECT
                date_on_display
            FROM
                shop_history
            WHERE
                user_id = :user_id
            group by
                created_at';
    return get_history_date($dbh , $sql);
}

function get_history_date($dbh , $sql){
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(user_id,$_SESSION['user_id'],PDO::PARAM_STR);
        $stmt->execute();
        $user_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $user_info;
}

function sql_get_order_history($dbh,$sort_kind){
    if($sort_kind === 'DESC' || $sort_kind === 'ASC') {
        $sql = 'SELECT
                    shop_items.id ,
                    shop_items.name ,
                    shop_items.price ,
                    shop_items.img,
                    shop_history.history_id,
                    shop_history.user_id,
                    shop_history.item_id,
                    shop_history.amount,
                    shop_history.date_on_display
                FROM
                    shop_items
                INNER JOIN
                    shop_history
                ON
                    shop_items.id = shop_history.item_id
                WHERE
                    shop_history.user_id = :user_id
                ORDER BY
                    shop_history.created_at '.$sort_kind;
        }
    return get_order_history($dbh , $sql);
}

function get_order_history($dbh , $sql){
    try {

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(user_id,$_SESSION['user_id'],PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $order_items[] = $row;
        }
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $order_items;
}
