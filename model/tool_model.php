<?php
function request_method($key){
    if($_SERVER['REQUEST_METHOD'] === $key)
    return TRUE;
}

function get_post_data($key) {
    $str = '';
    if (isset($_POST[$key]) === TRUE) {
        $str = ($_POST[$key]);
    }
    return $str;
}

function get_img_name() {
    //var_dump($_FILES);
    if (is_uploaded_file($_FILES['new_img']['tmp_name'])) {
        $img_tmp_name = ($_FILES['new_img']['tmp_name']);
        $extension = pathinfo($_FILES['new_img']['name'],PATHINFO_EXTENSION);
        $new_img_filename = sha1(uniqid(mt_rand(),true)) . '.' . $extension;
        //var_dump($new_img_filename);
        return $new_img_filename;
    }
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

function insert_user_comment_list($dbh,$name,$comment) {
    $sql = 'INSERT INTO post
                (user_name,user_comment)
            VALUES
                ( ? , ? )';
    return insert_db($dbh, $sql ,$name, $comment);
}

function insert_db($dbh, $sql, $name, $comment) {
    try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1,$name, PDO::PARAM_STR);
    $stmt->bindValue(2,$color, PDO::PARAM_STR);
    $stmt->bindValue(3,$price, PDO::PARAM_STR);
    $stmt->bindValue(4,$stock, PDO::PARAM_STR);
    $stmt->bindValue(5,$status, PDO::PARAM_STR);
    $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    }
    return true;
}
