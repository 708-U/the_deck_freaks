<?php

require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/functions.php';
require_once './model/login_model.php';

$css = './css/login.css';
$user_data = [];

// ログイン中はindexへ
if(check_session() === true) {
    redirect_index();
}
else if(request_method('POST')) {
    $flg_post = true;

    $user_data = get_post_logininfo();
    validate_logininfo($user_data);
}

//ログイン処理
if(check_err_msg() === true && $flg_post){
    try {
        $dbh = get_db_connect();

        if(login($dbh, $user_data) === true){
            redirect_index();
        }
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
}

include_once './view/header_view.php';
include_once './view/login_view.php';
include_once './view/footer_view.php';
