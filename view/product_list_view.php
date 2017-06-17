
    <main>
        <div class="container">
            <h1 class = "list-msg">商品一覧</h1>
        </div>
        <div class="container">
<?php foreach($on_sale_list as $key){ ?>
            <form method ='get' action = "./product_detail_controller.php">
                <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="product-box">
                            <input class="img-responsive product-box" type="image" src ="<?php echo h($img_dir .$key['img']); ?>" value ="">
                            <input type="hidden" name ="detail" value ="<?php echo h($key['id']); ?>">
                        </div>
                    <p class="caption"><?php echo h($key['name']); ?></p>
                </div>
            </form>
<?php } ?>
        </div>
    </main>
