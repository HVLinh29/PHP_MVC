<?php
include 'inc/header.php';
?>
<?php
if (isset($_GET['proid'])) {
    $customers_id = Session::get('customer_id');
    $proid = $_GET['proid'];
    $del_wl = $product->del_wl($proid, $customers_id);
}
?>
<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<h2>San pham yeu thich</h2>
				
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
					$get_whistlist = $product->get_whistlist($customers_id);
					if ($get_whistlist) {
						$i = 0;
						while ($result = $get_whistlist->fetch_assoc()) {
							$i++

					?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $result['productName'] ?></td>
								<td><img src="admin/uploads/<?php echo $result['hinhanh'] ?>" alt="" /></td>
								<td><?php echo $fm->format_currency($result['price']). " "."VND" ?></td>
								<td>
                                    <a href="?proid=<?php echo $result['productId'] ?>">Xoa</a> ||
                                    <a href="details.php?proid=<?php echo $result['productId'] ?>">Dat hang</a>
                                </td>
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