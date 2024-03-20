<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
        if (isset($_GET['orderid']) && $_GET['orderid'] == 'order') {
            $customers_id = Session::get('customer_id');
            $insertOrder = $ct->inserOrder($customers_id);
            $delCart = $ct->del_all_data_cart();
            header('Location:success.php');
        } 
        ?>
<form action="" method="POST">
    <div class="main">
        <div class="content">
            <div class="section group">
                <div class="content_top">
                    <div class="heading">
                        <h3>Thanh toan Offline</h3>
                    </div>
                    <div class="clear"></div>
                    <div class="box_left">
                        <div class="cartpage">

                            <?php
                            if (isset($update_sp_cart)) {
                                echo $update_sp_cart;
                            }
                            ?>
                            <?php
                            if (isset($del_cart)) {
                                echo $del_cart;
                            }
                            ?>
                            <table class="tblone">
                                <tr>
                                    <th width="5%">Id</th>
                                    <th width="15%">Ten san pham</th>
                                    <th width="15%">Gia tien</th>
                                    <th width="25%">So luong</th>
                                    <th width="20%">Tong tien</th>

                                </tr>
                                <?php
                                $get_product_cart = $ct->get_product_cart_checkout();
                                if ($get_product_cart) {
                                    $subtotal = 0;
                                    $qty = 0;
                                    $i = 0;
                                    while ($result = $get_product_cart->fetch_assoc()) {
                                        $i++;
                                ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $result['productName'] ?></td>

                                            <td><?php echo $fm->format_currency($result['price']). " "."VND" ?> </td>
                                            <td>
                                                <input type="number" name="soluong" min="0" value="<?php echo $result['soluong'] ?>" />
                                            </td>
                                            <td><?php $total = $result['price'] * $result['soluong'];
                                                echo $fm->format_currency($result['price']). " "."VND" ?></td>

                                        </tr>
                                <?php
                                        $subtotal += $total;
                                        $qty = $qty + $result['soluong'];
                                    }
                                }
                                ?>


                            </table>
                            <?php
                            $check_cart = $ct->check_cart();
                            if ($check_cart) {

                            ?>
                                <table style="float:right;text-align:left; " width="40%">
                                    <tr>
                                        <th>Sub Total : </th>
                                        <td><?php

                                            echo $fm->format_currency($subtotal). " "."VND";
                                            Session::set('sum', $subtotal);
                                            Session::set('qty', $qty);
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <th>VAT : </th>
                                        <td>10%(<?php echo  $vat = $subtotal * 0.1; ?>)</td>
                                    </tr>
                                    <tr>
                                        <th>Grand Total :</th>
                                        <td><?php
                                            $vat = $subtotal * 0.1;
                                            $gt = $subtotal + $vat;
                                            echo $gt . " "."VND";
                                            ?> </td>
                                    </tr>

                                </table>
                            <?php
                            } else {
                                echo 'Gio hang cua ban trong! Lam on dat hangg ngay bay gio';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="box_right">
                        <table class="tblone">
                            <?php
                            $id = Session::get('customer_id');
                            $get_customers = $cs->show_customer($id);
                            if ($get_customers) {
                                while ($result = $get_customers->fetch_assoc()) {

                            ?>
                                    <tr>
                                        <td>Ten</td>
                                        <td>:</td>
                                        <td><?php echo $result['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Thanh pho</td>
                                        <td>:</td>
                                        <td><?php echo $result['city'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>So dien thoai</td>
                                        <td>:</td>
                                        <td><?php echo $result['phone'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Que Quan</td>
                                        <td>:</td>
                                        <td><?php echo $result['country'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Zipcode</td>
                                        <td>:</td>
                                        <td><?php echo $result['zipcode'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td><?php echo $result['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dia chi</td>
                                        <td>:</td>
                                        <td><?php echo $result['address'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><a href="editprofile.php">Update Profile</a></td>

                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <center><a href="?orderid=order" class="submit_order">Order Now</a></center>
    </div>
</form>
<?php
include 'inc/footer.php';
?>
<style>
    .box_left {
        width: 50%;
        border: 1px solid #666;
        float: left;
        padding: 4px;
    }

    .box_right {
        width: 46%;
        border: 1px solid #666;
        float: left;
        padding: 4px;
    }
    a.submit_order{
        padding: 10px 70px;
        background: red;
        font-size: 25px;
        color: #fff;
       
        cursor: pointer;
    }
</style>