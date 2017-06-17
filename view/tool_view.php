
    <main>
        <div class = "container">
            <h1 class = "text-center cart-msg">商品在庫管理</h1>
        </div>
        <?php if(isset($err_msg)){ ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                <strong>登録失敗</strong>:<?php echo h($err_msg[0]);  ?>
            </div>
        <?php } else if(isset($success_msg)) {?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                <strong>登録成功</strong>:<?php echo h($success_msg[0]);  ?>
            </div>
        <?php } ?>
        <!-- 在庫管理 -->
        <form method="POST" enctype ="multipart/form-data">
            <div class = "container cart-box">
                <table class ="table">
                    <tr>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <!-- <th>色</th> -->
                        <th>値段</th>
                        <th>在庫</th>
                        <th>公開する</th>
                        <th></th>
                    </tr>

                    <tr>
                        <div class = "form-inline">
                            <td>
                                <div>
                                    <input type="file" class= "form-control" name="new_img">
                                </div>
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="input-sm text-left form-control" type="text" name ="name" placeholder="商品名">
                            </td>
                            <!-- <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="color" placeholder="color" size ="11">
                            </td> -->
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="price" placeholder="price" size ="11">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input class ="form-group-sm text-left form-control" type="text" name ="stock" placeholder="0" size ="9">
                            </td>
                            <td class = "text-center td_vertical_align_middle">
                                <input type="checkbox" name ="status" value ="1">
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
    <div class = "container">
        <h1 class = "text-center cart-msg registerd-msg">登録済み商品リスト</h1>
    </div>
    <!-- 既存商品管理 -->
        <div class = "container cart-box">
<?php foreach($product_list as $key){ ?>
            <table class ="table">
                <tr>
                    <th class = "text-center">写真</th>
                    <th class = "text-center">商品名</th>
                    <!-- <th class = "text-center">色</th> -->
                    <th class = "text-center">値段</th>
                    <th class = "text-center">在庫</th>
                    <th class = "text-center">ステータス</th>
                </tr>
                <tr>
                    <th class = "text_center"><a><img src = "./product_img/<?php echo h($key['img']); ?>" class = "img-responsive table-img"></a></th>
                    <th class = "text-center"><?php echo h(($key['name'])); ?></th>
                    <!-- <th class = "text-center"><?php echo h($key['color']); ?></th> -->
                    <th class = "text-center">￥<?php echo h($key['price']); ?></th>
                    <th class = "text-center"><?php echo h($key['stock']); ?></th>
                    <th class = "text-center">
                        <?php if($key['status'] === 1) {echo h('公開中');} else {echo h('非公開中');} ?>
                    </th>
                        <form method = "post">
                            <th class = "text-center td_vertical_align_middle">
                                <input class="form-control btn btn-warning" type="submit" value ="削除">
                                <input type ="hidden" name="process_kind" value="delete_product">
                                <input type = "hidden" name="id" value ="<?php echo h($key['id']); ?>">
                            </th>
                        </form>
                    </tr>
                    <form method ="POST">
                        <tr>
                            <div class = "form-inline">
                                <td></td>
                                <td class = "text-center td_vertical_align_middle">
                                    <input class ="form-group-sm text-left form-control" type="text" name ="change_name" placeholder="<?php echo h($key['name']); ?>">
                                </td>
                                <!-- <td class = "text-center td_vertical_align_middle">
                                    <input class ="form-group-sm text-left form-control" type="text" name ="change_color" placeholder="<?php echo h($key['color']); ?>">
                                </td> -->
                                <td class = "text-center td_vertical_align_middle">
                                    <input class ="form-group-sm text-left form-control" type="text" name ="change_price" placeholder="￥<?php echo h($key['price']); ?>" size ="12">
                                </td>
                                <td class = "text-center td_vertical_align_middle">
                                    <input class ="form-group-sm text-left form-control" type="text" name ="change_stock" placeholder="<?php echo h($key['stock']); ?>" size = "5">
                                </td>
                                <td class = "text-center td_vertical_align_middle">
                                    <select class ="form-control" name = "change_status">
<?php if($key['status'] === 1){ ?>
                                        <option value="1">公開</option>
                                        <option value="0">非公開</option>
<?php } else { ?>
                                        <option value="0">非公開</option>
                                        <option value="1">公開</option>
<?php } ?>
                                    </select>
                                </td>
                                <td class = "text-center td_vertical_align_middle">
                                    <input type = "submit" class ="btn btn-info td_vertical_align_middle" value ="更新" >
                                    <input type = "hidden" name="process_kind" value ="change_product_info">
                                    <input type = "hidden" name="id" value ="<?php echo h($key['id']); ?>">
                                </td>
                            </div>
                        </tr>
                    </form>
                    <tr>

                    </tr>
            </table>
<?php } ?>
        </div>
    <!-- 既存在庫管理ここまで -->
    </main>
