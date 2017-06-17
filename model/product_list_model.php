<?php
function sql_get_product_data($dbh) {
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
                shop_items.id = shop_stocks.id';
    return get_product_data($dbh,$sql);
}

function get_product_data($dbh,$sql) {
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $list[] = $row;
        }
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return except_not_sale($list);
}

function except_not_sale($list){
    foreach($list as $key) {
        if($key['status'] === 1) {
            $on_sale_list[] = $key;
        }
    }
    return $on_sale_list;
}
