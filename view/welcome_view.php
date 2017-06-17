
    <main>
        <div class="container">
            <h1 class = "login-msg text-center">ようこそ、<?php echo h($_SESSION['user_name']) ?>さん！</h1>
        </div>
        <form>
            <div class="container login-box">
                <div class ="hat">
                    <img class ="hat" src="./img/hat.png" alt="">
                </div>
                <div class = "container-fluid text-center">
                    <p class = "text-center succese-msg">アカウントの作成に成功しました！</p>
                    <p class = "text-center succese-msg">登録した情報はユーザーページから変更できます。</p>
                </div>
            </div>
        </form>
        <div class="container btn-index">
            <a href ="index_controller.php" class ="btn btn-warning btn-block">Topに戻る</a>
        </div>
    </main>
