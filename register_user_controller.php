<?php

require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/functions.php';
require_once './model/register_user_model.php';

$css = './css/register_user.css';

if(check_session()){
    header('location:./index_controller.php');
    exit;
}


$err_msg = get_flush_err_msg();


include_once './view/header_view.php';
include_once './view/register_user_view.php';
include_once './view/footer_view.php';
