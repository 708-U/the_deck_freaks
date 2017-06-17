
    <main>
        <div class = "container">
            <h1 class = "text-center cart-msg">商品をカートに追加しました！</h1>
        </div>
        <form>
            <div class = "container cart-box">
                <table class ="table table-hover">
                    <tr>
                        <th></th>
                        <th class = "text-center">商品名</th>
                        <!-- <th class = "text-center">色</th> -->
                        <th class = "text-center">数</th>
                        <th class = "text-center">小計</th>
                    </tr>

                    <tr>
                        <div class = "form-inline">
                            <td><a><img src = "<?php echo h('./product_img/' . ($product_data[0]['img'])); ?>" class = "img-responsive table-img"></a></td>
                            <td class = "text-center td_vertical_align_middle"><?php echo h($product_data[0]['name']); ?>
                            </td>
                            <!-- <td class = "text-center td_vertical_align_middle">
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
                            </td> -->
                            <td class = "text-center td_vertical_align_middle">
                                <?php echo h($order_quantity); ?>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                ￥<?php  echo h($product_data[0]['price'] * $order_quantity);?>
                            </td>
                        </div>
                    </tr>
                </table>
                <a class ="btn btn-warning btn-block" href="cart_controller.php">購入画面に進む</a>
                <p class ="text-center or">or</p>
                <a class ="btn btn-warning btn-block" href="product_list_controller.php">商品一覧に戻る</a>
            </div>
        </form>
        <div class="container">

        </div>
    </main>
