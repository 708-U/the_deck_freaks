
    <main>
        <div class="container">
            <h1 class = "login-msg text-center"><?php echo h($user_info[0]['name']) ?>さんの登録情報</h1>
        </div>
        <form>
            <div class="container login-box">
                <div class ="hat">
                    <img class ="hat" src="./img/hat.png" alt="">
                </div>
                <div class="form-user-info">
                    <div class="form-horizontal">
                        <div class="form-group ">
                            <label class="control-label">ユーザー名</label>
                            <div class = "">
                    		    <input type="text" class="form-control col-xs-12 input-name" readonly placeholder="<?php echo h($user_info[0]['name']) ?>">
                            </div>
                            <label class = "control-label">アドレス</label>
                            <div class = "">
                    		    <input type="text" class="form-control input-name" readonly placeholder="<?php echo h($user_info[0]['email']) ?>">
                            </div>
                            <label class = "control-label">パスワード</label>
                            <div class = "">
                    		    <input type="password" class="form-control input-name" readonly value="●●●●●●●●">
                            </div>
                            <label class = "control-label">獲得ポイント数 :　<?php echo h($user_info[0]['point']) ?></label>
                        </div>
                    </div>
                </div>
                <!-- <a href = "useredit_controller." class ="btn btn-warning btn-block">登録情報を編集する</a> -->
            </div>
        </form>
    </main>
