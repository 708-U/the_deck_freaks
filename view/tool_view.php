<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Deck freaks</title>
    <!-- <link rel = "stylesheet" href = "html5reset-1.6.1.css"> -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel = "stylesheet" href = "cart.css">
</head>
<body>
    <nav class="navbar  navbar-fixed-top">
        <div class="container-fluid">
    		<div class="navbar-header">
        		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
    				<span class="sr-only">Toggle navigation</span>
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    			</button>
    			<a class="navbar-brand " href="cart.html">
                    <img alt ="Brand" class="icon" src = "./img/cart.png">
                </a>
    		</div>

    		<div class="collapse navbar-collapse text-center" id="navbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a class = "nav-item" href="index.html">TOPページ</a></li>
                    <li class="active"><a class = "nav-item" href="userinfo.html">ユーザー情報</a></li>
                    <li class="active"><a class = "nav-item" href="login.html">ログイン</a></li>
                    <li class="active"><a class = "nav-item" href="register_user.html">会員登録</a></li>
                    <li class="active"><a class = "nav-item" href="product_list.html">商品一覧</a></li>
                    <li class="active"><a class = "nav-item" href="purchase_history.html">購入履歴</a></li>
                    <li class="active"><a class = "nav-item" href="customor_form.html">お問い合わせ</a></li>
                </ul>
    		</div>
    	</div>
    </nav>

    <div class = "nav-header text-center">
        <h1 class = "nav-h1">The <span class = "logo-bold">Deck</span> freaks</h1>
    </div>

    <main>
        <!-- <?php var_dump($_FILES);?> -->
        <?php var_dump($new_img_filename);?>
        <div class = "container">
            <h1 class = "text-center cart-msg">商品在庫管理</h1>
        </div>
        <!-- 在庫管理 -->
        <form method="POST" enctype ="multipart/form-data">
            <div class = "container cart-box">
                <table class ="table">
                    <tr>
                        <th class = "text-center">商品画像</th>
                        <th class = "text-center">商品名</th>
                        <th class = "text-center">色</th>
                        <th class = "text-center">値段</th>
                        <th class = "text-center">在庫</th>
                        <th class = "text-center">ステータス</th>
                        <th class = "text-center"></th>
                    </tr>

                    <tr>
                        <div class = "form-inline">
                            <td>
                                <div>
                                    <input type="file" class= "form-control" name="product_img">
                                </div>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="name" placeholder="商品名">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="color" placeholder="color" size ="11">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" \type="text" name ="price" placeholder="price" size ="11">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="stock" placeholder="0" size ="4">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <select class = "form-control" name="status">
                                    <option>公開</option>
                                    <option>非公開</option>
                                </select>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input type = "submit" class ="btn btn-primary td_vertical_align_middle" value ="登録" >
                                <input type ="hidden" name="process_kind" value="add_new_product">
                            </td>
                        </div>
                    </tr>
                </table>
            </div>
        </form>
    <!-- 在庫管理ここまで -->
    <!-- 既存商品管理 -->
        <form method="POST">
            <div class = "container cart-box">
                <table class ="table">
                    <tr>
                        <th></th>
                        <th class = "text-center">商品名</th>
                        <th class = "text-center">色</th>
                        <th class = "text-center">値段</th>
                        <th class = "text-center">在庫</th>
                        <th class = "text-center">ステータス</th>
                        <th class = "text-center"></th>
                    </tr>

                    <tr>
                        <div class = "form-inline">
                            <td><a><img src = "./img/IMG_0475.jpg" class = "img-responsive table-img"></a></td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="product_name" placeholder="ABSOLUTE DECK">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <div class = "form-group-sm">
                                <select class = "form-control">
                                    <option>
                                        青
                                    </option>
                                    <option>
                                        赤
                                    </option>
                                </select>
                                </div>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="product_name" placeholder="5500" size ="5">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <div class = "form-group-sm">
                                <select class = "form-control">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                                </div>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <select class = "form-control">
                                    <option>公開</option>
                                    <option>非公開</option>
                                </select>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input type = "submit" class ="btn btn-primary td_vertical_align_middle" value ="更新" >
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class = "form-inline">
                            <td><a><img src = "./img/IMG_0475.jpg" class = "img-responsive table-img"></a></td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="product_name" placeholder="ABSOLUTE DECK">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <div class = "form-group-sm">
                                <select class = "form-control">
                                    <option>
                                        青
                                    </option>
                                    <option>
                                        赤
                                    </option>
                                </select>
                                </div>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="product_name" placeholder="5500" size ="5">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <div class = "form-group-sm">
                                <select class = "form-control">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                                </div>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <select class = "form-control">
                                    <option>公開</option>
                                    <option>非公開</option>
                                </select>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input type = "submit" class ="btn btn-primary td_vertical_align_middle" value ="更新" >
                            </td>
                        </div>
                    </tr>
                </table>
            </div>
        </form>
    <!-- 既存在庫管理ここまで -->
    </main>
    <footer>
        <div class="container">
            <p class ="text-left copy">copyright</p>
        </div>

    </footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
