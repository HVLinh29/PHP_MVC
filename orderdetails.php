<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>

<?php
$ct = new cart();
$login_check = Session::get('customer_login');
if ($login_check == false) {
    header('Location:login.php');
} 
if (isset($_GET['cfid'])) {
	$id = $_GET['cfid'];
	$time = $_GET['time'];
	$price = $_GET['price'];
	$shifted_cf = $ct->shifted_cf($id, $time, $price);
}
?>
<div class="main">
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">
                <h2>Gio hang cua ban</h2>

                <table class="tblone">
                    <tr>
                        <th width="10%">Id</th>
                        <th width="20%">Ten san pham</th>
                        <th width="10%">Hinh anh</th>
                        <th width="15%">Gia tien</th>
                        <th width="25%">So luong</th>
                        <th width="10%">Date</th>
                        <th width="10%">Status</th>
                        <th width="10%">Action</th>
                    </tr>
                    <?php
                    $customers_id = Session::get('customer_id');
                    $get_cart_ordered = $ct->get_cart_ordered($customers_id);
                    if ($get_cart_ordered) {
                        $i = 0;
                        $qty = 0;
                        while ($result = $get_cart_ordered->fetch_assoc()) {
                            $i++

                    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $result['productName'] ?></td>
                                <td><img src="admin/uploads/<?php echo $result['hinhanh'] ?>" alt="" /></td>
                                <td><?php echo $fm->format_currency($result['price']). " "."VND" ?></td>
                                <td><?php echo $result['soluong'] ?></td>
                                <td><?php echo $fm->formatDate($result['date_order']) ?></td>
                                <td><?php
                                    if ($result['status'] == 0) {
                                        echo 'Dang xu ly';
                                    } elseif($result['status'] == 1) {
                                       ?>
                                       <span>Dang van chuyen hang</span>
                                       
                                       <?php
                                    }elseif($result['status'] == 2){
                                        echo 'Da nhan';
                                    }
                                    ?></td>
                                <?php
                                if ($result['status'] == 0) {
                                ?>
                                 <td><?php echo 'N/A';?></td>
                                <?php
                               
                                } elseif($result['status']==1) {
                                ?>
                                <td><a href="?cfid=<?php echo $customers_id ?>&price=<?php echo  $result['price'] ?>
								&time=<?php echo $result['date_order'] ?>">Confirmed</a><td>
                                <?php
                                }else{
                                ?>
                                    <td><?php echo 'Da nhan';?></td>
                                <?php
                                }
                                ?>
                            </tr>
                    <?php

                        }
                    }
                    ?>


                </table>

            </div>
            <div class="shopping">
                <div class="shopleft">
                    <a href="index.php"> <img src="images/shop.png" alt="" /></a>
                </div>
                
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php
include 'inc/footer.php';
?>