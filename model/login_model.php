<?php

function get_post_logininfo(){
    // trimming -> 前後空白スペース削除
    $user_name = trimming(get_post_data('user_name'));
    $user_pass = trimming(get_post_data('user_pass'));
    $user_data = ['user_name'=>$user_name,
                  'user_pass'=>$user_pass];
    return $user_data;
}

function validate_logininfo($param){
    if(!validate_name($param)){
        return false;
    }
    if(!validate_pass($param)){
        return false;
    }
    return true;
}

function validate_name($param){
    if($param['user_name'] === '') {
        return set_err_msg('ユーザーネームが入力されていません');
    }
    // 入力文字が半角かどうかチェック
    else if(strlen($param['user_name']) !== mb_strlen($param['user_name'])) {
        return set_err_msg('ユーザーネームに全角文字が含まれています');
    }
    else if(mb_strlen($param['user_name']) < 5) {
        return set_err_msg('ユーザーネームは5文字以上にして下さい');
    }
    else if(mb_strlen($param['user_name']) >= 20) {
        return set_err_msg('ユーザーネームは20文字以内にして下さい');
    }
    return true;
}

function validate_pass($param){
    if($param['user_pass'] === '') {
        return set_err_msg('パスワードが入力されていません');
    }
    // 入力文字が半角かどうかチェック
    else if(strlen($param['user_pass']) !== mb_strlen($param['user_pass'])) {
        return set_err_msg('パスワードに全角文字が含まれています');
    }
    else if(mb_strlen($param['user_pass']) < 6) {
        return set_err_msg('パスワードは6文字以上にして下さい');
    }
    else if(mb_strlen($param['user_pass']) >= 20) {
        return set_err_msg('パスワードは20文字以内にして下さい');
    }
    return true;
}

// ログイン、クッキー処理
function login($dbh,$param){
    $data = sql_check_registered_data($dbh,$param);

    if($data['count(*)'] === 1){
        session_set_user_id($data);
        cookie_set_name($data['name']);
        return true;
    }
    else {
        return set_err_msg('入力値が間違っています');
    }
}

function sql_check_registered_data($dbh ,$param) {
    $sql = 'SELECT
                count(*) ,id ,name
            FROM
                shop_users
            WHERE
                name = :name and password = :pass';
    return check_registered_data($dbh,$sql,$param);
}

function check_registered_data($dbh,$sql,$param) {
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(name,$param['user_name'], PDO::PARAM_STR);
        $stmt->bindValue(pass,$param['user_pass'], PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetch();
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $count;
}

function session_set_user_id($data){
    session_start();
    $_SESSION['user_id'] = $data['id'];
    $_SESSION['user_name'] = $data['name'];
    $_SESSION['logged'] = true;
}

function cookie_set_name($name){
    $check = get_post_data('save_data');
    if($check === 'save_data') {
        setcookie('user_name',$name,time() + 60*60*60*24);
    } else {
        setcookie('user_name','',time() -40000);
    }
}
