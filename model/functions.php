<?php

function request_method($key){
    if($_SERVER['REQUEST_METHOD'] === $key){
        return TRUE;
    }
    else {
        return FALSE;
    }
}

function get_post_data($key) {
    if (isset($_POST[$key]) === TRUE) {
        $str = $_POST[$key];
    }
    return $str;
}

function get_GET_data($key) {
    if (isset($_GET[$key]) === TRUE) {
        $str = $_GET[$key];
    }
    return $str;
}

function check_session() {
    session_start();
    if(isset($_SESSION['user_id'])) {
        return true;
    }
    else {
        return false;
    }
}

function trimming($str){
    return preg_replace('/\A[\s　]|[\s　]\z/u', '', $str);
}


// エラーメッセージをグローバル化してエラーチェックに対応させる
function set_err_msg($msg){
    global $err_msg;
    $err_msg[] = $msg;
}

function set_success_msg($msg){
    global $success_msg;
    $success_msg [] = $msg;
}

function check_err_msg(){
    if(count($err_msg) > 0){
        return false;
    }
    return true;
}

function check_flush_msg(){
    if(count($_SESSION['msg']) > 0){
        return false;
    }
    return true;
}

function check_flush_err(){
    if(count($_SESSION['err_msg']) > 0){
        return false;
    }
    return true;
}

function set_flush_msg($msg){
    if(isset($_SESSION['msg']) === false){
        $_SESSION['msg'] = array();
    }
    $_SESSION['msg'][] = $msg;
}

function set_flush_err_msg($msg){
    global $_err_msg;
    $_err_msg = $msg;
    $_SESSION['err_msg'][] = $_err_msg;
}

function get_flush_msg(){
    if(isset($_SESSION['msg']) === TRUE){
        $msg = $_SESSION['msg'];
        $_SESSION['msg'] = array();
        return $msg;
    }
    return array();
}

function get_flush_err_msg(){
    if(isset($_SESSION['err_msg']) === TRUE){
        $err_msg = $_SESSION['err_msg'];
        $_SESSION['err_msg'] = array();
        return $err_msg;
    }
    return array();
}

function h($str){
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARSET);
}

function redirect_index(){
    header('location:./index_controller.php');
    exit;
}

function redirect_login(){
    header('location:./login_controller.php');
    exit;
}

function redirect_cart(){
    header('location:./cart_controller.php');
    exit;
}

function get_db_connect(){
    try {
    // データベースに接続
        $dbh = new PDO(DNS, DB_USER, DB_PASSWD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
        echo '接続できませんでした。理由：'.$e->getMessage();
        }
    return $dbh;
}

function sql_get_order_data($dbh){
    $sql = 'SELECT
                shop_items.id,
                shop_items.name,
                shop_items.price,
                shop_items.img,
                shop_items.color,
                shop_items.status,
                shop_stocks.stock,
                shop_cart.id,
                shop_cart.user_id,
                shop_cart.item_id,
                shop_cart.amount
            FROM
                shop_items
            INNER JOIN
                shop_stocks
            ON
                shop_items.id = shop_stocks.id
            INNER JOIN
                shop_cart
            ON
                shop_items.id = shop_cart.item_id
            WHERE
                shop_cart.user_id = :user_id';
    return get_order_data($dbh,$sql,$param);
}

function get_order_data($dbh,$sql,$param){
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(user_id,$_SESSION['user_id'],PDO::PARAM_STR);
        $stmt->execute();
        $product_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $product_list;
}

function sql_get_user_data($dbh){
    $sql = 'SELECT
                id,name,email,point
            FROM
                shop_users
            WHERE
                id = :user_id';
    return get_user_data($dbh , $sql);
}

function get_user_data($dbh , $sql){
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(user_id,$_SESSION['user_id'],PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $user_info[] = $row;
        }
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $user_info;
}

// カート内支払料金計算
function calc_payment($param) {
    $total_sum = [];
    $total_sum['total'] = calc_total_payment($param);
    $total_sum['shippment'] = calc_shippment($total_sum);
    $total_sum['Grandtotal'] = $total_sum['total'] + $total_sum['shippment'];
    return $total_sum;
}

function calc_total_payment($param){
    foreach($param as $key) {
        $price = $key['price'] * $key['amount'];
        $sum +=$price;
    }
    return $sum;
}

function calc_shippment($param){
    if((int)$param['total'] < 5000){
        $cost = 500;
    }
    else {
        $cost = 0;
    }
    return $cost;
}

function calc_total_amount($param){
    foreach ($param as $key) {
        $sum += $key['amount'];
    }
return $sum;
}

function calc_give_point($param){
    $point = floor($param['total'] / 100);
    return $point;
}

function get_date(){
    $date = date('Y-m-d H:i:s');
    return $date;
}

// スクリプトの更新日付を返す
function echo_filedate($filename) {
  if (file_exists($filename)) {
    echo date('YmdHis', filemtime($filename));
  }
  else {
    echo 'file not found';
  }
}
