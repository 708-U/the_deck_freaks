<?php

function sql_get_product_detail($dbh,$data) {
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
                shop_items.id = :id';
    return get_product_detail($dbh,$sql,$data);
}

function get_product_detail($dbh,$sql,$data) {
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(id,$data, PDO::PARAM_STR);
        $stmt->execute();
        $get_data = $stmt->fetchall();
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $get_data;
}
