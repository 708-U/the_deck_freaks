

    <main>
        <div class="container">
            <h1 class = "login-msg text-center">アカウント作成</h1>
        </div>
        <form method ="post" action ="welcome_controller.php">
            <div class="container login-box">
                <div class ="hat">
                    <img class ="hat" src="./img/hat.png" alt="">
                </div>
            <?php if(isset($err_msg[0])){ ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                    <strong>登録失敗</strong>:<?php echo h($err_msg[0]);  ?>
                </div>
            <?php } ?>
                <div class="form-user-info">
                    <div class="form-group ">
                		<input type="text" class="form-control input-name" name="user_name" placeholder="ユーザーネーム">
                		<input type="mail" class="form-control input-name" name="user_mail" placeholder="メールアドレス">
                        <input type="password" class="form-control" name="user_pass" placeholder="パスワード">
                	</div>
                </div>
                <input type="submit" value="新しいアカウントを作成" class ="btn btn-warning btn-block" >
            </div>
        </form>
    </main>
