<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
if (isset($_GET['cartid'])) {
    $cartid = $_GET['cartid'];
    $del_cart = $ct->del_product_cart($cartid);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $cartId = $_POST['cartId'];
    $soluong = $_POST['soluong'];
    $update_sp_cart = $ct->update_sp_cart($soluong, $cartId);
    if ($soluong <= 0) {
        $del_cart = $ct->del_product_cart($cartId);
    }
}
?>
<!-- <?php
        if (!isset($_GET['id'])) {
            echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
        }
        ?> -->
<div class="main">
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">

                <h2>Cong thanh toan OL</h2>

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

                        <th width="20%">Ten san pham</th>
                        <th width="10%">Hinh anh</th>
                        <th width="15%">Gia tien</th>
                        <th width="25%">So luong</th>
                        <th width="20%">Tong tien</th>
                        <th width="10%">Action</th>
                    </tr>
                    <?php
                    $get_product_cart = $ct->get_product_cart();
                    if ($get_product_cart) {
                        $subtotal = 0;
                        $qty = 0;
                        while ($result = $get_product_cart->fetch_assoc()) {

                    ?>
                            <tr>
                                <td><?php echo $result['productName'] ?></td>
                                <td><img src="admin/uploads/<?php echo $result['hinhanh'] ?>" alt="" /></td>
                                <td><?php echo $fm->format_currency($result['price']) . "" . "VND" ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="cartId" value="<?php echo $result['cartId'] ?>" />
                                        <input type="number" name="soluong" min="0" value="<?php echo $result['soluong'] ?>" />
                                        <input type="submit" name="submit" value="Update" />
                                    </form>
                                </td>
                                <td><?php $total = $result['price'] * $result['soluong'];
                                    echo  $fm->format_currency($total) . " " . "VND"; ?></td>
                                <td><a href="?cartid=<?php echo $result['cartId'] ?>">Xoa</a></td>
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
                    <table style="float:right;text-align:left;" width="40%">
                        <tr>
                            <th>Sub Total : </th>
                            <td><?php

                                echo  $fm->format_currency($subtotal) . " " . "VND";
                                Session::set('sum', $subtotal);
                                Session::set('qty', $qty);
                                ?></td>
                        </tr>
                        <tr>
                            <th>VAT : </th>
                            <td>10%</td>
                        </tr>
                        <tr>
                            <th>Grand Total :</th>
                            <td><?php
                                $vat = $subtotal * 0.1;
                                $gt = $subtotal + $vat;
                                echo  $gt . " " . "VND";
                                ?> </td>
                        </tr>
                    </table>
                <?php
                } else {
                    echo 'Gio hang cua ban trong! Lam on dat hangg ngay bay gio';
                }
                ?>
            </div>
            <?php
            $check_cart = $ct->check_cart();
            if (Session::get('customer_id') == true && $check_cart) {
            ?>

                <form action="thanhtoan_vnpay.php" method="POST">
                    <input type="hidden" name="total_congthanhtoan" value="<?php echo $gt ?>">
                    <button class="btn btn-success" name="redirect" id="redirect">Thanh toan VNPAY</button>
                </form>
                <p></p>
                <form action="thanhtoan_momo.php" method="POST">
                    <input type="hidden" name="total_congthanhtoanQR" value="<?php echo $gt ?>">
                    <button class="btn btn-danger" name="redirect" id="redirect">Thanh toan QR MOMO</button>
                </form>
                <p></p>
                <form action="thanhtoan_momoatm.php" method="POST">
                    <input type="hidden" name="total_congthanhtoanATM" value="<?php echo $gt ?>">
                    <button class="btn btn-danger" name="redirect" id="redirect">Thanh toan ATM MOMO</button>
                </form>
                <p></p>
                <form action="thanhtoan_onepay.php" method="POST">
                    <input type="hidden" name="total_congthanhtoan" value="<?php echo $gt ?>">
                    <button class="btn btn-danger" name="redirect" id="redirect">Thanh toan ONEPAY</button>
                </form>

            <?php
            } else {
            ?>
                <a class="btn btn-success btn-thanhtoan" href="cart.php">Quay ve gio hang</a>
            <?php
            }

            ?>
            <style>
                a.btn-thanhtoan {
                    display: block;
                    width: 33%;
                    margin: 6px auto;
                }
            </style>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php
include 'inc/footer.php';
?>