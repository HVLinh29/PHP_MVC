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
	$stock = $_POST['stock'];
	$update_sp_cart = $ct->update_sp_cart($stock, $soluong, $cartId);
	if ($soluong <= 0) {
		$del_cart = $ct->del_product_cart($cartId);
	}
}
?>
<?php
if (!isset($_GET['id'])) {
	echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
}
?>
<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<h2>Your Cart</h2>
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
						<th width="20%">Ton kho</th>
						<th width="10%">Hinh anh</th>
						<th width="15%">Gia tien</th>
						<th width="25%">So luong</th>
						<th width="20%">Tong tien</th>
						<th width="10%">Buy</th>
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
								<td><?php echo $result['stock'] ?></td>
								<td><img src="admin/uploads/<?php echo $result['hinhanh'] ?>" alt="" /></td>
								<td><?php echo $fm->format_currency($result['price']) . "" . "VND" ?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartId" value="<?php echo $result['cartId'] ?>" />
										<input type="hidden" name="stock" value="<?php echo $result['stock'] ?>" />
										<input type="number" name="soluong" min="0" value="<?php echo $result['soluong'] ?>" />
										<input type="submit" name="submit" value="Update" />
									</form>
								</td>
								<td><?php $total = $result['price'] * $result['soluong'];
									echo  $fm->format_currency($total) . " " . "VND"; ?></td>
								<td>
									<div class="form-check">
										<input class="form-check-input buy_checked" 
										<?php echo $result['status']==1 ? 'checked': '' ?>
										type="checkbox" value="<?php echo $result['cartId']?>" id="defaultCheck1">
										<label class="form-check-label" for="defaultCheck1">
											Mua
										</label>
									</div>
								</td>
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
				<a class="btn btn-success btn-thanhtoan" href="payment.php">Thanh toan gio hang</a>
			<?php
			} else {
			?>
				<a class="btn btn-success btn-thanhtoan" href="login.php">Dang nhap dat hang</a>
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