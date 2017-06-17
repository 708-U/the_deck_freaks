
    <main>
        <div class = "container">
            <h1 class = "text-center cart-msg">ショッピングカート</h1>
        </div>

        <!-- <form> -->
            <div class = "container cart-box">
<?php if(isset($err_msg)){ ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                    <strong>入力エラー</strong>:<?php echo h($err_msg[0]);  ?>
                </div>
<?php } else if(isset($success_msg)) { ?>
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                    <strong>更新成功</strong>:<?php echo h($success_msg[0]);  ?>
                </div>
<?php } ?>
                <table class ="table table-hover">
                    <tr>
                        <th></th>
                        <th class = "text-center">商品名</th>
                        <!-- <th class = "text-center">色</th> -->
                        <th class = "text-center">数量</th>
                        <!--<th></th>-->
                        <th class = "text-center">更新</th>
                        <th class = "text-center">小計</th>
                    </tr>
<?php foreach($product_data as $key) { ?>
                    <tr>
                        <div class = "form-inline">
                            <td>
                                <a><img src = "./product_img/<?php echo h($key['img']); ?>" class = "table-img"></a>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <?php echo($key['name']); ?>
                            </td>
                            <form method ="post" action = "./cart_process_controller.php">
                                <input type = "hidden" name = "cart_id" value = "<?php echo h($key['id']); ?>">
                                <input type = "hidden" name = "stock" value = "<?php echo h($key['stock']); ?>">
                                <!-- <td class = "text-center td_vertical_align_middle">
                                    <div class = "form-group-sm">
                                    <select class = "form-control" name = "color">
                                        <option>
                                            青
                                        </option>
                                        <option>
                                            赤
                                        </option>
                                    </select>
                                    </div>
                                </td> -->
                                <td class = "text-center td_vertical_align_middle">
                                    <div class = "form-group-sm">
                                        <input class = "form-control" type = "text" name ="quantity" value = "<?php echo h($key['amount']); ?>" size = "10">
                                    </div>
                                </td>
                                <td class = "text-center td_vertical_align_middle">
                                    <!--<input type = "submit" class ="btn btn-primary td_vertical_align_middle" value ="更新" >-->
                                    <button class ="btn btn-primary td_vertical_align_middle">
                                        <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </form>
                            <!--<form method = "post" action = "./cart_process_controller.php">-->
                            <!--    <td class = "text-center td_vertical_align_middle">-->
                            <!--        <input type ="image" class = "img-responsive trashbox td_vertical_align_middle" src = "./img/trashbox.png">-->
                            <!--        <input type = "hidden" name = "cart_id" value = "<?php echo $key['id']; ?>">-->
                            <!--        <input type = "hidden" name = "sql_kind" value = "delete_product">-->
                            <!--    </td>-->
                            <!--</form>-->
                            <td class = "text-center td_vertical_align_middle">￥<?php echo h($key['price'] * $key['amount']) ?></td>
                        </div>
                    </tr>
<?php } ?>
                </table>

                <div class="container=fluid pull-left">
                    <p class ="text-left">獲得予定ポイント：<span class="label label-primary"><?php echo h($give_point); ?></span></p>
                    <p class ="text-left">現在所持ポイント：<span class="label label-primary"><?php echo h($point); ?></span></p>
                </div>
                <div class="container-fluid pull-right">
                    <p class ="text-left">小計：￥<?php echo h($payment['total']) ?></p>
                    <p class ="text-left">送料：￥<?php echo h($payment['shippment']) ?></p>
                    <p class ="text-left grandtotal">合計：￥<?php echo h($payment['Grandtotal']) ?></p>
                </div>
                <form class="" action="thanks_controller.php" method="post">
                    <input type = "hidden" name = "user_id" value ="<?php echo h($user_id); ?>">
                    <input type = "hidden" name = "process_kind" value = "purchase">
                    <input type = "submit" class ="btn btn-warning btn-block" value ="購入" >
                </form>
            </div>
    </main>
