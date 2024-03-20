<?php
include 'inc/header.php';
?>
<?php
$login_check = Session::get('customer_login');
if ($login_check == false) {
    header('Location:login.php');
} 
?>

<div class="main">
    <div class="content">
        <div class="section group">
        <div class="content_top">
    		<div class="heading">
            <h3 class="payment">Chi tiet lich su don hang</h3>
    		</div>
    		<div class="clear"></div>
            <div class="wrapper_method">
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
                $order_code= $_GET['order_code'];
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
                            <td><img src=admin/uploads/<?php echo $result['hinhanh']?> width="100px"></td>
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
        </div>
    </div>
</div>

<?php
include 'inc/footer.php';
?>
