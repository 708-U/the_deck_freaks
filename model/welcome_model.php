<?php

function redirect_register(){
    header('location:./register_user_controller.php');
    exit;
}

function get_post_userinfo(){
    //trimming -> 前後空白スペース削除
    $user_data = ['user_name'=>trimming(get_post_data('user_name')),
                  'user_mail'=>trimming(get_post_data('user_mail')),
                  'user_pass'=>trimming(get_post_data('user_pass'))];
    return $user_data;
}

function validate_userinfo($param){
    if(!validate_name($param)){
        return false;
    }
    if(!validate_mail($param)){
        return false;
    }
    if(!validate_pass($param)){
        return false;
    }
    return true;
}

function validate_name($param){
    if($param['user_name'] === '') {
        return set_flush_err_msg('ユーザーネームが入力されていません');
    }
    // 入力文字が半角かどうかチェック
    else if(strlen($param['user_name']) !== mb_strlen($param['user_name'])) {
        return set_flush_err_msg('ユーザーネームに全角文字が含まれています');
    }
    else if(mb_strlen($param['user_name']) < 5) {
        return set_flush_err_msg('ユーザーネームは5文字以上にして下さい');
    }
    else if(mb_strlen($param['user_name']) >= 20) {
        return set_flush_err_msg('ユーザーネームは20文字以内にして下さい');
    }
    return true;
}

function validate_mail($param){
    $email_regex = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD';
    if(preg_match($email_regex, $param['user_mail'])) {
        return true;
    }
    else{
        return set_flush_err_msg('メールアドレスが正しい形式ではありません');
    }
}

function validate_pass($param){
    if($param['user_pass'] === '') {
        return set_flush_err_msg('パスワードが入力されていません');
    }
    // 入力文字が半角かどうかチェック
    else if(strlen($param['user_pass']) !== mb_strlen($param['user_pass'])) {
        return set_flush_err_msg('パスワードに全角文字が含まれています');
    }
    else if(mb_strlen($param['user_pass']) < 6) {
        return set_flush_err_msg('パスワードは6文字以上にして下さい');
    }
    else if(mb_strlen($param['user_pass']) >= 20) {
        return set_flush_err_msg('パスワードは20文字以内にして下さい');
    }
    return true;
}

function try_register_user_data($dbh,$param){
    // ユーザーネーム重複なしで登録実行、セッションセット
    if(sql_check_registerd_name($dbh,$param) === true) {
        sql_insert_user_data($dbh,$param);

        $new_id = sql_get_new_id($dbh ,$param);
        session_set_user_id($new_id);

    }
    else{
        set_flush_err_msg('既に入力されたユーザーネームは使われています。');
        redirect_register();
    }
}

function sql_check_registerd_name($dbh,$param) {
    $sql = 'SELECT
                count(name)
            FROM
                shop_users
            WHERE
                name = :name';
    return check_registerd_name($dbh,$sql,$param);
}

function check_registerd_name($dbh,$sql,$param) {
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(name,$param['user_name'], PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetch();
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    if($count[0] === 0){
        return true;
    }
    else{
        return false;
    }
}

function sql_insert_user_data($dbh, $data) {
    $sql = 'INSERT INTO shop_users
                (name,password,email,created_at)
            VALUES
                (:name , :password ,:mail ,:date)';
    return insert_db_user_data($dbh, $sql ,$data);
}

function insert_db_user_data($dbh, $sql, $data) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(name,$data['user_name'], PDO::PARAM_STR);
    $stmt->bindValue(password,$data['user_pass'], PDO::PARAM_STR);
    $stmt->bindValue(mail,$data['user_mail'], PDO::PARAM_STR);

    $date =get_date();
    $stmt->bindValue(date,$date, PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    }
}

function sql_get_new_id($dbh,$param) {
    $sql = 'SELECT
                id,name,password
            FROM
                shop_users
            WHERE
                name = :name and password = :pass';
    return get_new_id($dbh,$sql,$param);
}

function get_new_id($dbh,$sql,$param) {
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(name,$param['user_name'], PDO::PARAM_STR);
        $stmt->bindValue(pass,$param['user_pass'], PDO::PARAM_STR);
        $stmt->execute();
        $new_id = $stmt->fetch();
    } catch (PDOException $e) {
        echo 'DBエラー：'.$e->getMessage();
    }
    return $new_id;
}

function session_set_user_id($data){
    session_start();
    $_SESSION['user_id'] = $data['id'];
    $_SESSION['user_name'] = $data['name'];
    $_SESSION['logged'] = true;
}
