<?php

require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/welcome_model.php';

$css = './css/welcome.css';

$user_data = [];

// ログイン中はリダイレクト
if(check_session() === true) {
    redirect_index();
}
else {
    $user_data = get_post_userinfo();
    validate_userinfo($user_data);
}

// ポスト以外を弾く
if(request_method('POST') === false){
    redirect_register();
}
else if(check_flush_err() === false){
    redirect_register();
}
else{
    try{
        $dbh = get_db_connect();
        
        // 失敗時登録画面にリダイレクト
        try_register_user_data($dbh,$user_data);

    } catch (PDOException $e) {
    echo '接続できませんでした。理由：'.$e->getMessage();
    }
}

include_once './view/header_view.php';
include_once './view/welcome_view.php';
include_once './view/footer_view.php';
