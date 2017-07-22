<?php
// 設定ファイル読み込み
require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/functions.php';
require_once './model/tool_model.php';

$css          = './css/tool.css';
$img_dir      = './product_img/';
$product_data = [];

// 処理リクエストを判別
if(request_method('POST')) {
    $process_kind = get_post_data('process_kind');
    $product_id   = get_post_data('id');
}


// 処理ごとにエラーチェック、正規化、バリデーション($err_msgにエラー代入)
if($process_kind === 'add_new_product') {
// 追加商品情報を配列にして取得
    $product_data = get_post_product();

    if(validate_post_data($product_data) === true){
    // 画像ファイルをリネームして./product_imgに保存
        move_new_img($product_data,$img_dir);
        $flg_add = true;
    }
}

if($process_kind === 'change_product_info') {
// 変更情報を配列にして取得
    $change_product_data = get_post_change();

    if(validate_post_change($change_product_data)) {
        $flg_change = true;
    }
}

if($process_kind === 'delete_product') {
    $flg_delete = true;
}


// エラー存在時は処理をさせない
if(check_err_msg()) {
    try {
        $dbh = get_db_connect();

    //flagに応じた処理を実行
        if($flg_add) {
            try_insert_products_data($dbh,$product_data);
        }
        else if($flg_change) {
            try_update_products_data($dbh,$change_product_data);
        }
        else if($flg_delete) {
            try_delete_product($dbh,$product_id);
        }

    // 管理商品データを取得
        $product_list = sql_get_product_data($dbh);

        } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
}

include_once './view/header_view.php';
include_once './view/tool_view.php';
include_once './view/footer_view.php';
