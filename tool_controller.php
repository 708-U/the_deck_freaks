<?php
// 設定ファイル読み込み
require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/tool_model.php';

if(request_method('POST')) {
    $process_kind = get_post_data('process_kind');
}

if($process_kind === 'add_new_product') {
    $ok='ok';
    $name = get_post_data('name');
    $color = get_post_data('color');
    $price = get_post_data('price');
    $stock = get_post_data('stock');
    $status = get_post_data('status');
}

var_dump($_FILES);
$new_img_filename = get_img_name();

$product_data = ["$name","$color","$price","$stock","$status"];

// $dbh = get_db_connect();
//
// insert_db($name,$color,$price,$stock,$status);

include_once './view/tool_view.php';
