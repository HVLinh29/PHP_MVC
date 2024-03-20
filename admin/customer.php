<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/category.php'; ?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/customer.php');
include_once($filepath . '/../helpers/format.php');

?>
<?php
$cs = new customer();
if (!isset($_GET['customerid']) || $_GET['customerid'] == NULL) {
    echo "<script>window.location = 'inbox.php'</script>";
} else {
    $id = $_GET['customerid'];
    $order_code = $_GET['order_code'];
}

?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Chi tiet don hang</h2>

        <div class="block copyblock">

            <?php
            $get_customer = $cs->show_customer($id);
            if ($get_customer) {
                while ($result =  $get_customer->fetch_assoc()) {
            ?>
                    <form action="" method="POST">
                        <h3>Thong tin nguoi dat</h3>
                        <table class="form">
                            <tr>
                                <td>Ten</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['name'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>So dien thoai</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['phone'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>Que quan</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['country'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>Dia chi</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['address'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>Thanh pho</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['city'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['email'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>Zip Code</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['zipcode'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>

                        </table>
                    </form>
            <?php
                }
            }
            ?>

        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Ten san pham</th>
                    <th>Hinh anh</th>
                    <th>Gia san pham</th>
                    <th>So luong</th>
                    <th>Thanh tien</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $get_order = $cs->show_order($order_code);
                if ($get_order) {
                    $subtotal = 0;
                    $total = 0;
                    while ($result =   $get_order->fetch_assoc()) {
                        $subtotal = $result['soluong'] * $result['price'];
                        $total += $subtotal;
                ?>
                        <tr>
                            <td><?php echo $result['productName'] ?></td>
                            <td><img src=uploads/<?php echo $result['hinhanh']?> width="100px"></td>
                            <td><?php echo number_format($result['price'], 0, ',', '.') ?></td>
                            <td><?php echo $result['soluong'] ?></td>
                            <td><?php echo number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                <?php
                    }

                }
                ?>
                <tr>
                    <td colspan="5">Thanh tien: <?php  echo number_format($total, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<?php include 'inc/footer.php'; ?>