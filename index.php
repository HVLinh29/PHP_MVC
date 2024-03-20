<?php
include 'inc/header.php';
include 'inc/slider.php';

?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['themgiohang'])) {

	$soluong = $_POST['soluong'];
	$product_stock = $_POST['stock'];
	$id = $_POST['productId'];
	$insertCart = $ct->add_to_cart($soluong, $product_stock, $id);
	if($insertCart){
		echo "<script>window.location = 'cart.php'</script>";
	}
}
?>
<div class="main">
	<div class="content">
		<div class="content_top">
			<div class="heading">
				<h3>SẢN PHẨM NỔI BẬT</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$product_feathered = $product->getproduct_feathered();
			if ($product_feathered) {
				while ($result = $product_feathered->fetch_assoc()) {

			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php"><img src="admin/uploads/<?php echo $result['hinhanh'] ?>" alt="" /></a>
						<h2><?php echo $result['productName'] ?> </h2>
						<p><?php echo $fm->textShorten($result['mota'], 20) ?></p>
						<p><span class="price"><?php echo $fm->format_currency($result['price']) . "" . "VND" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result['productId'] ?>" class="details">Details</a></span></div>
						<form method="POST" action="">
							<input type="hidden" name="soluong" value="1" />
							<input type="hidden" name="stock" value="<?php echo $result['product_quantity'] ?>" />
							<input type="hidden" name="productId" value="<?php echo $result['productId'] ?>" />
							<input type="submit" name="themgiohang" value="Them gio hang" class="btn btn-success ">
						</form>
					</div>
			<?php
				}
			}
			?>
		</div>
		<div class="content_bottom">
			<div class="heading">
				<h3>SẢN PHẨM MỚI</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$product_new = $product->getproduct_new();
			if ($product_new) {
				while ($result_new = $product_new->fetch_assoc()) {

			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php"><img src="admin/uploads/<?php echo $result_new['hinhanh'] ?>" alt="" /></a>
						<h2><?php echo $result_new['productName'] ?> </h2>
						<p><?php echo $fm->textShorten($result_new['mota'], 20) ?></p>
						<p><span class="price"><?php echo $fm->format_currency($result_new['price']) . "" . "VND" ?></span></p>
						<form method="POST" action="">
							<input type="hidden" name="soluong" value="1" />
							<input type="hidden" name="stock" value="<?php echo $result_new['product_quantity'] ?>" />
							<input type="hidden" name="productId" value="<?php echo $result_new['productId'] ?>" />
							<input type="submit" name="themgiohang" value="Them gio hang" class="btn btn-success ">
						</form>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_new['productId'] ?>" class="details">Chi tiet</a></span></div>
					</div>

			<?php
				}
			}
			?>
		</div>
		<div class="">
			<?php

			$product_all = $product->get_all_product();
			$product_count = mysqli_num_rows($product_all);
			$product_button = ceil($product_count / 4);
			$i = 1;
			echo '<p>Trang :</p>';
			for ($i = 1; $i <= $product_button; $i++) {
				echo '<a style="margin:0 5px;" href="index.php?trang=' . $i . '">' . $i . '</a>';
			}
			?>
		</div>
	</div>
</div>
<?php
include 'inc/footer.php';
?>