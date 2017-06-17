
<main>
    <div class = "container">
        <h1 class = "text-center cart-msg">ご購入ありがとうございます!</h1>
    </div>
    <form>
        <div class = "container cart-box">
            <table class ="table">
                <tr>
                    <th></th>
                    <th class = "text-center">商品名</th>
                    <!-- <th class = "text-center">色</th> -->
                    <th class = "text-center">数</th>
                    <th class = "text-center">単価</th>
                    <th class = "text-center">合計</th>
                </tr>
<?php foreach($order_data as $key){ ?>
                <tr>
                    <td><a><img src = "./product_img/<?php echo h($key['img']) ?>" class = "img-responsive table-img"></a></td>
                    <td class = "text-center td_vertical_align_middle"><?php echo h($key['name']) ?>
                    </td>
                    <!-- <td class = "text-center td_vertical_align_middle">青</td> -->
                    <td class = "text-center td_vertical_align_middle"><?php echo h($key['amount']) ?></td>
                    <td class = "text-center td_vertical_align_middle">￥<?php echo h($key['price']) ?></td>
                    <td class = "text-center td_vertical_align_middle">￥<?php echo h($key['price'] * $key['amount']) ?></td>
                </tr>
<?php } ?>
            </table>
            <div class="container=fluid pull-left">
                <p class ="text-left">獲得ポイント：<span class="label label-primary"><?php echo h($give_point); ?></span></p>
                <p class ="text-left">所持ポイント：<span class="label label-primary"><?php echo h($calcleted_point); ?></span></p>
            </div>
            <div class="container-fluid pull-right">
                <p class ="text-left">小計：￥<?php echo h($payment['total']) ?></p>
                <p class ="text-left">送料：￥<?php echo h($payment['shippment']) ?></p>
                <p class ="text-left">合計：￥<?php echo h($payment['Grandtotal']) ?></p>
            </div>
            <div class="container col-xs-12 btn-list">
                <a href ="index_controller.php" class ="btn btn-warning btn-block">トップページに戻る</a>
            </div>
        </div>
    </form>
</main>
