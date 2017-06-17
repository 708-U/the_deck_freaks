
    <main>
        <div class="container-fluid">
            <h1 class = "login-msg text-center">ログイン</h1>
        </div>
        <form method ="post">
            <div class="container login-box">
                <div class ="hat">
                    <img class ="hat" src="./img/hat.png" alt="">
                </div>
<?php if(isset($err_msg)){ ?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                        <strong>認証失敗</strong>:<?php echo h($err_msg[0]);  ?>
                    </div>
<?php } ?>
                <div class="form-user-info">
                    <div class="form-group">
                		<input type="text" class="form-control input-name" name="user_name" placeholder="ユーザーネーム" value ="<?php echo h($_COOKIE['user_name']);?>">
                        <input type="password" class="form-control" name="user_pass" placeholder="パスワード">
                	</div>
                </div>
                <div class="checkbox input-lg">
                    <label for="name-checked" >
                        <input type="checkbox" name="save_data" value="save_data" <?php if(isset($_COOKIE['user_name'])) { echo h('checked');} ?>><span class="save-name">ユーザーネームを記録する
                    </span>
                    </label>
                </div>
                <!-- <input type = "submit" class ="btn btn-warning btn-block" value="ログイン"> -->
                <input type ="submit" class ="btn btn-warning btn-block" value ="ログイン">
                <!--<div class = "first-visit container text-center">-->
                    <p class = "new-customer text-center">初めてのお客様ですか？</p>
                <!--</div>-->
                <a class ="btn btn-warning btn-block" href = "./register_user_controller.php">新しいアカウントを作成</a>
            </div>
        </form>
    </main>
