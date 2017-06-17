    <main>
        <div class = "container">
            <h1 class = "text-center cart-msg"><?php echo h($_SESSION['user_name']) ?>さんの購入履歴</h1>
        </div>
        <div class = "container cart-box">
            <table class ="table table-hover">
                <tr>
                    <th></th>
                    <th class = "text-center">商品名</th>
                    <!-- <th class = "text-center">色</th> -->
                    <th class = "text-center">数</th>
                    <th class = "text-center">合計金額</th>
                    <th class = "text-center">購入日時</th>
                </tr>
<?php foreach($order_items as $key){?>
                <tr>
                    <div class = "form-inline">
                        <td><a><img src = "./product_img/<?php echo h($key['img']) ?>" class = "img-responsive table-img"></a></td>
                        <td class = "text-center td_vertical_align_middle"><?php echo h($key['name']) ?>
                        </td>
                        <!-- <td class = "text-center td_vertical_align_middle">青</td> -->
                        <td class = "text-center td_vertical_align_middle">
                            <?php echo h($key['amount']) ?>
                        </td>
                        <td class = "text-center td_vertical_align_middle">￥<?php echo h($key['price'] * $key['amount']) ?></td>
                        <td class = "text-center td_vertical_align_middle">
                            <?php echo h($key['date_on_display']) ?>
                        </td>
                    </div>
                </tr>
<?php } ?>
            </table>
            <!-- <div class="container-fluid pull-right">
                <p class ="text-left">小計：￥11000</p>
                <p class ="text-left">送料：￥0</p>
                <p class ="text-left">合計：￥11000</p>
            </div> -->
        </div>
    </main>
