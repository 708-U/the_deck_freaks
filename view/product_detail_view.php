
    <main>
        <div class="container">
            <h1 class = "list-msg"><?php echo h($product_detail[0]['name']); ?></h1>
        </div>
        <div class="container">
            <div class="col-xs-12 col-md-6">
                    <div class="product-box">
                        <img class = "img-responsive" src = "./product_img/<?php echo h($product_detail[0]['img']); ?>">
                    </div>
                <p class="caption"></p>
            </div>
            <div class="col-xs-12 col-md-6">
                <p class="caption"><?php echo h('￥' . $product_detail[0]['price']); ?></p>
<?php if($product_detail[0]['stock'] > 0) { ?>
                <p class="caption">在庫あり</p>
<?php } else { ?>
                <p class="caption">売り切れ</p>
<?php } ?>
            </div>
            <div class = "container col-xs-12 cart-box">
<?php if($product_detail[0]['stock'] > 0){ ?>
                <form  class ="col-xs-12 form-inline" method = "post" action = "add_cart_controller.php">
<?php if(isset($err_msg[0])){ ?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                        <strong>入力エラー</strong>:<?php echo h($err_msg[0]);  ?>
                    </div>
<?php } ?>
                    <input class = "form-control" type = "hidden" name = "product_id" value = "<?php echo h($product_detail[0]['id']); ?>">
                    <label class ="text-center">個数</label>
                    <input class = "form-control" type = "text" name ="order_quantity">
                    <!-- <input class = "form-controll btn" type = "text" name ="order_color"> -->
                    <input class = "btn btn-warning btn-block"type = "submit" value=" カートに入れる">
                </form>
<?php } ?>
                <div class="container col-xs-12 btn-list">
                    <a href ="product_list_controller.php" class ="btn btn-warning btn-block">商品一覧に戻る</a>
                </div>
            </div>
        </div>
    </main>
