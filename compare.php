<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<!-- <?php
		if (isset($_GET['cartid'])) {
			$cartid = $_GET['cartid'];
			$del_cart = $ct->del_product_cart($cartid);
		}
		// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
		// 	$cartId = $_POST['cartId'];
		// 	$soluong = $_POST['soluong'];
		// 	$update_sp_cart = $ct->update_sp_cart($soluong, $cartId);
		// 	if ($soluong <= 0) {
		// 		$del_cart = $ct->del_product_cart($cartId);
		// 	}
		// }
		?> -->
<!-- <?php
if (!isset($_GET['id'])) {
	echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
}
?> -->
<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<h2>So sanh san pham</h2>
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
						<th width="10*">Id</th>
						<th width="20%">Ten san pham</th>
						<th width="40%">Hinh anh</th>
						<th width="15%">Gia tien</th>
						<th width="15%">Action</th>

					</tr>
					<?php
					$customers_id = Session::get('customer_id');
					$get_compare = $product->get_compare($customers_id);
					if ($get_compare) {
						$i = 0;
						while ($result = $get_compare->fetch_assoc()) {
							$i++

					?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $result['productName'] ?></td>
								<td><img src="admin/uploads/<?php echo $result['hinhanh'] ?>" alt="" /></td>
								<td><?php echo $fm->format_currency($result['price']). " "."VND" ?></td>
								<td><a href="details.php?proid=<?php echo $result['productId'] ?>">View</a></td>
							</tr>
					<?php

						}
					}
					?>


				</table>



			</div>
			<div class="shopping">
				<div class="shopleft">
					<center><a href="index.php"> <img src="images/shop.png" alt="" /></a></center>
				</div>
				
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
include 'inc/footer.php';
?>