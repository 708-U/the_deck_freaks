<?php

function get_post_product(){
    $product_data = ['name'    => trimming(get_post_data('name')),
                     'price'   => trimming(get_post_data('price')),
                     'new_img' => trimming(get_img_name()),
                     'status'  => trimming(get_post_data('status')),
                     'stock'   => trimming(get_post_data('stock'))];
    return $product_data;
}

function get_img_name() {
    if (is_uploaded_file($_FILES['new_img']['tmp_name'])) {
        $extension = pathinfo($_FILES['new_img']['name'],PATHINFO_EXTENSION);
        $new_img = sha1(uniqid(mt_rand(),true)) . '.' . $extension;
        return $new_img;
    }
}

function move_new_img($param,$img_dir){
    $img_tmp_name = $_FILES['new_img']['tmp_name'];
    if(is_file($img_dir . $param['new_img']) !== TRUE) {
        if((move_uploaded_file($img_tmp_name , $img_dir . $param['new_img']))) {
            return TRUE;
        }
    } else {
        set_err_msg('処理に失敗しました。もう一度お試しください。');
    }
}

function validate_post_data($param){
    if(!validate_name($param)){
        return false;
    }
    else if(!validate_price($param)){
        return false;
    }
    else if(!validate_img($param)){
        return false;
    }
    else if(!validate_status($param)){
        return false;
    }
    else if(!validate_stock($param)){
        return false;
    }
    return true;
}

function validate_name($param){
    if($param['name'] === '') {
        return set_err_msg('名前が入力されていません');
    }
    else if(mb_strlen($param['name']) > 21) {
        return set_err_msg('名前は20文字以内にして下さい');
    }
    return true;
}

function validate_price($param){
    if($param['price'] === '') {
        return set_err_msg('値段が入力されていません');
    }
    else if(!is_numeric($param['price'])){
        return set_err_msg('値段は数値か半角英数字を入力して下さい');
    }
    else if(mb_strlen($param['price']) > 5) {
        return set_err_msg('値段は99999円以内にして下さい');
    }
    return true;
}

function validate_img($param){
    if($param['new_img'] === '') {
        return set_err_msg('画像が選択されていません');
    }
    return true;
}

function validate_status($param){
    if(!($param['status'] === '' || $param['status'] === '1')) {
        return set_err_msg('入力値エラー');
    }
    return true;
}

function validate_stock($param){
    if($param['stock'] === '') {
        return set_err_msg('在庫数が入力されていません');
    }
    else if(!is_numeric($param['stock'])){
        return set_err_msg('在庫数は数字かつ半角英数字を入力して下さい');
    }
    else if(mb_strlen($param['stock']) > 3) {
        return set_err_msg('在庫数は999個以内にして下さい');
    }
    return true;
}

function get_post_change(){
    $change_name = get_post_data('change_name');
    $change_price = get_post_data('change_price');
    // $change_color = get_post_data('change_color');
    $change_status = get_post_data('change_status');
    $change_stock = get_post_data('change_stock');
    $product_id = get_post_data('id');

    $change_product_data = ['name'=>$change_name, 'price'=>$change_price,'color'=>$change_color ,'status'=>$change_status,'stock'=>$change_stock,'id'=>$product_id];
    return $change_product_data;
}

function validate_post_change($param){
    if(!validate_change_name($param)){
        return false;
    }
    else if(!validate_change_price($param)){
        return false;
    }
    else if(!validate_change_status($param)){
        return false;
    }
    else if(!validate_change_stock($param)){
        return false;
    }
    return true;
}

// 以下バリデートは複数データが同時に入力された時に対応するため、
// 値であればバリデートせずそのままtrueを返す

function validate_change_name($param){
    if($param['name'] === ''){
        return true;
    }

    if(mb_strlen($param['name']) > 21) {
        return set_err_msg('名前は20文字以内にして下さい');
    }
    return true;
}

function validate_change_price($param){
    if($param['price'] === ''){
        return true;
    }

    if(!is_numeric($param['price'])){
        return set_err_msg('値段は数値か半角英数字を入力して下さい');
    }
    else if(mb_strlen($param['price']) > 5) {
        return set_err_msg('値段は99999円以内にして下さい');
    }
    return true;
}

function validate_change_status($param){
    if($param['status'] === ''){
        return true;
    }

    if(!($param['status'] === '' || $param['status'] === '1')) {
        return set_err_msg('入力値エラー');
    }
    return true;
}

function validate_change_stock($param){
    if($param['stock'] === ''){
        return true;
    }

    if(!is_numeric($param['stock'])){
        return set_err_msg('在庫数は数字かつ半角英数字を入力して下さい');
    }
    else if(mb_strlen($param['stock']) > 3) {
        return set_err_msg('在庫数は999個以内にして下さい');
    }
    return true;
}


function try_insert_products_data($dbh,$product_data) {
    sql_insert_products_data($dbh, $product_data);
    sql_insert_stocks($dbh, $product_data);
    return $set_success_msg('新しい商品を登録しました！');
}

function sql_insert_products_data($dbh, $product_data) {
    $sql = 'INSERT INTO shop_items
                (name,price,img,status,created_at)
            VALUES
                (:name,:price,:new_img,:status,:date)';
    return insert_db_product_data($dbh, $sql ,$product_data);
}

function insert_db_product_data($dbh, $sql,$product_data) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(name,$product_data['name'], PDO::PARAM_STR);
    $stmt->bindValue(price,$product_data['price'], PDO::PARAM_INT);
    $stmt->bindValue(new_img,$product_data['new_img'],PDO::PARAM_STR);
    // $stmt->bindValue(color,$product_data['color'], PDO::PARAM_STR);
    $stmt->bindValue(status,$product_data['status'], PDO::PARAM_INT);

    $date = get_date();
    $stmt->bindValue(date,$date, PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    }
}

function sql_insert_stocks($dbh, $product_data) {
    $sql = 'INSERT INTO shop_stocks
                (stock , created_at)
            VALUES
                (:stock ,:date)';
    return insert_db_stocks($dbh, $sql ,$product_data);
}

function insert_db_stocks($dbh, $sql,$product_data) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(stock,$product_data['stock'], PDO::PARAM_STR);

    $date = get_date();
    $stmt->bindValue(date,$date, PDO::PARAM_STR);

    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    };
}

function try_update_products_data($dbh,$change_product_data) {
    if($change_product_data['name'] !== ''){
        $flag = sql_update_name($dbh, $change_product_data);
    }
    if($change_product_data['price'] !==''){
        $flag = sql_update_price($dbh, $change_product_data);
    }
    if($change_product_data['color'] !==''){
        $flag = sql_update_color($dbh, $change_product_data);
    }
    if($change_product_data['stock'] !==''){
        sql_update_stocks($dbh, $change_product_data);
    }
    if($change_product_data['status'] === 1 || $change_product_data['status'] === 2){
        $flag = sql_update_status($dbh, $change_product_data);
    }
    if($flag === TRUE) {
        sql_update_at($dbh,$change_product_data);
        return set_success_msg('登録情報を更新しました！');
    }
    return set_err_msg('更新情報を入力して下さい');
}

function sql_update_name($dbh, $change_product_data) {
    $sql = 'UPDATE
                shop_items
            SET
                name = :name
            WHERE
                id = :id';
    return update_db_name($dbh, $sql ,$change_product_data);
}

function update_db_name($dbh, $sql,$change_product_data) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(name,$change_product_data['name'], PDO::PARAM_STR);
    $stmt->bindValue(id,$change_product_data['id'], PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    };
    return TRUE;
}

function sql_update_price($dbh, $change_product_data) {
    $sql = 'UPDATE
                shop_items
            SET
                price = :price
            WHERE
                id = :id';
    return update_db_price($dbh, $sql ,$change_product_data);
}

function update_db_price($dbh, $sql,$change_product_data) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(price,$change_product_data['price'], PDO::PARAM_STR);
    $stmt->bindValue(id,$change_product_data['id'], PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    };
    return TRUE;
}

function sql_update_color($dbh, $change_product_data) {
    $sql = 'UPDATE
                shop_items
            SET
                color = :color
            WHERE
                id = :id';
    return update_db_color($dbh, $sql ,$change_product_data);
}

function update_db_color($dbh, $sql,$change_product_data) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(color,$change_product_data['color'], PDO::PARAM_STR);
    $stmt->bindValue(id,$change_product_data['id'], PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    };
    return TRUE;
}

function sql_update_status($dbh, $change_product_data) {
    $sql = 'UPDATE
                shop_items
            SET
                status = :status
            WHERE
                id = :id';
    return update_db_status($dbh, $sql ,$change_product_data);
}

function update_db_status($dbh, $sql,$change_product_data) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(status,$change_product_data['status'], PDO::PARAM_STR);
    $stmt->bindValue(id,$change_product_data['id'], PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    };
    return TRUE;
}

function sql_update_stocks($dbh, $change_product_data) {
    $sql = 'UPDATE
                shop_stocks
            SET
                stock = :stock
            WHERE
                id = :id';
    return update_db_stocks($dbh, $sql ,$change_product_data);
}

function update_db_stocks($dbh, $sql,$change_product_data) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(stock,$change_product_data['stock'], PDO::PARAM_STR);
    $stmt->bindValue(id,$change_product_data['id'], PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    };
    return sql_stocks_update_at($dbh,$change_product_data);
}

function sql_stocks_update_at($dbh,$change_product_data) {
    $sql = 'UPDATE
                shop_stocks
            SET
                updated_at = :date
            WHERE
                id = :id';
    return update_db_update_at($dbh, $sql,$change_product_data);
}

function sql_update_at($dbh,$change_product_data) {
    $sql = 'UPDATE
                shop_items
            SET
                updated_at = :date
            WHERE
                id = :id';
    return update_db_update_at($dbh, $sql,$change_product_data);
}

function update_db_update_at($dbh, $sql,$change_product_data) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(date,date('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->bindValue(id,$change_product_data['id'], PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    };
    return TRUE;
}

function try_delete_product($dbh,$product_id){
    sql_delete_product_items($dbh,$product_id);
    sql_delete_product_stocks($dbh,$product_id);
    return set_success_msg('商品を正常に削除しました');
}

//sql削除！危険！！
function sql_delete_product_items($dbh,$product_id){
    $sql = 'DELETE
            FROM
                shop_items
            WHERE
                id = :id';
        return delete_product($dbh,$sql,$product_id);
}

function sql_delete_product_stocks($dbh,$product_id){
    $sql = 'DELETE
            FROM
                shop_stocks
            WHERE
                id = :id';
        return delete_product($dbh,$sql,$product_id);
}

function delete_product($dbh,$sql,$product_id){
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(id,$product_id, PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    };
}

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
        $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $product_list[] = $row;
        }
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $product_list;
}
