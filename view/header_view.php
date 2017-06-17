<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Deck freaks</title>
    <!-- <link href="css/default.css?date=<?php echo_filedate("css/default.css"); ?>" rel="stylesheet"> -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel = "stylesheet" href ="<?php echo h($css); ?>">
    <link rel = "stylesheet" href ="./css/header_footer.css">
    <!-- <link href="css/default.css?date=<?php echo_filedate("css/default.css"); ?>" rel="stylesheet"> -->
    <link rel = "icon" href ="./img/hat.png" type = "image/png">
</head>
<body>
    <nav class="navbar  navbar-fixed-top">
        <div class="container-fruid">
    		<div class="navbar-header">
        		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
    				<span class="sr-only">Toggle navigation</span>
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    			</button>
    			<a class="navbar-brand " href="cart_controller.php">
                    <img alt ="Brand" class="icon" src = "./img/cart.png">
                    <span class="badge cart-amount"><?php echo h($total_amount); ?></span></a>
                </a>
    		</div>
<?php if(!isset($_SESSION['user_id'])) { ?>
<!-- ログイン前 -->
    		<div class="collapse navbar-collapse text-center" id="navbar">
    			<ul class="nav navbar-nav">
                    <li class="active"><a class = "nav-item" href="index_controller.php">トップ</a></li>
                    <li class="active"><a class = "nav-item" href="login_controller.php">ログイン</a></li>
    				<li class="active"><a class = "nav-item" href="register_user_controller.php">会員登録</a></li>
    				<li class="active"><a class = "nav-item" href="product_list_controller.php">商品一覧</a></li>
    			</ul>
    		</div>
<?php } else { ?>
<!-- ログイン後 -->
            <div class="collapse navbar-collapse text-center" id="navbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a class = "nav-item" href="userinfo_controller.php">こんにちは、<?php echo h($_SESSION['user_name']) ?>さん</a></li>
                    <li class="active"><a class = "nav-item" href="index_controller.php">TOPページ</a></li>
                    <li class="active"><a class = "nav-item" href="product_list_controller.php">商品一覧</a></li>
                    <li class="active"><a class = "nav-item" href="purchase_history_controller.php">購入履歴</a></li>
                    <li class="active"><a class = "nav-item" href="logout_controller.php">ログアウト</a></li>
                </ul>
            </div>
<?php } ?>
        </div>
    </nav>
    <div class = "nav-header text-center">
        <h1 class = "nav-h1"><a class ="logo-a" href ="./index_controller.php">The <span class = "logo-bold">Deck</span> freaks</a></h1>
    </div>

<?php if(DEBUG === true) {?>
    <p><?php var_dump($debug); ?></p>
<?php } ?>
